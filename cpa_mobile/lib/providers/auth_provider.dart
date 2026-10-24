import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:dio/dio.dart';
import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';
import '../models/user_model.dart';
import '../services/notification_service.dart';

class AuthProvider with ChangeNotifier {
  User? _user;
  String? _token;
  bool _isLoading = false;
  String? _errorMessage;

  User? get user => _user;
  String? get token => _token;
  bool get isAuthenticated => _token != null;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;
  
  bool get isAdmin => _user?.role == 'admin';
  bool get isSalesman => _user?.role == 'salesman';
  bool get isRetailer => _user?.role == 'retailer';
  bool get isBiller => _user?.role == 'biller';

  Future<void> init() async {
    final prefs = await SharedPreferences.getInstance();
    _token = prefs.getString('auth_token');
    if (_token != null) {
      await fetchUser();
      // Sync FCM token upon session restore
      NotificationService.instance.syncTokenWithBackend(role: _user?.role);
    }
    notifyListeners();
  }

  Future<bool> login(String email, String password) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await ApiClient.instance.post(
        ApiConstants.login,
        data: {
          'email': email.trim().toLowerCase(),
          'password': password,
        },
      );

      _token = response.data['token']?.toString();
      final userRaw = response.data['user'];
      final userData = userRaw is Map ? Map<String, dynamic>.from(userRaw) : <String, dynamic>{};
      _user = User.fromJson(userData);
      
      // Override role from backend correctly and ensure fallback name
      final backendRole = (response.data['role'] ?? _user!.role).toString().toLowerCase();
      _user = User(
        id: _user!.id,
        name: _user!.name.trim().isNotEmpty ? _user!.name : (backendRole == 'admin' ? 'Admin' : 'User'),
        email: _user!.email,
        role: backendRole,
        phone: _user!.phone,
        companyName: _user!.companyName,
        address: _user!.address,
        salesmanId: _user!.salesmanId,
      );

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', _token!);

      // Sync device FCM push notification token with backend
      NotificationService.instance.syncTokenWithBackend(role: backendRole);

      _isLoading = false;
      notifyListeners();
      return true;
    } on DioException catch (e) {
      _isLoading = false;
      _errorMessage = _extractDioError(e, 'Login failed. Please check your credentials or connection.');
      notifyListeners();
      return false;
    } catch (e) {
      _isLoading = false;
      _errorMessage = 'An unexpected error occurred: ${e.toString()}';
      notifyListeners();
      return false;
    }
  }

  Future<bool> register({
    required String name,
    required String email,
    required String password,
    required String phone,
    required String companyName,
    required String address,
    required String dlNumber,
    String? gstNumber,
  }) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await ApiClient.instance.post(
        ApiConstants.register,
        data: {
          'name': name.trim(),
          'email': email.trim(),
          'password': password,
          'phone': phone.trim(),
          'company_name': companyName.trim(),
          'address': address.trim(),
          'dl_number': dlNumber.trim(),
          if (gstNumber != null && gstNumber.trim().isNotEmpty)
            'gst_number': gstNumber.trim().toUpperCase(),
          'role': 'retailer',
        },
      );

      _token = response.data['token']?.toString();
      final userRaw = response.data['user'];
      final userData = userRaw is Map ? Map<String, dynamic>.from(userRaw) : <String, dynamic>{};
      _user = User.fromJson(userData);
      final backendRole = (response.data['role'] ?? _user!.role).toString().toLowerCase();
      _user = User(
        id: _user!.id,
        name: _user!.name.trim().isNotEmpty ? _user!.name : 'User',
        email: _user!.email,
        role: backendRole,
        phone: _user!.phone,
        companyName: _user!.companyName,
        address: _user!.address,
        salesmanId: _user!.salesmanId,
      );

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', _token!);

      _isLoading = false;
      notifyListeners();
      return true;
    } on DioException catch (e) {
      _isLoading = false;
      _errorMessage = _extractDioError(e, 'Registration failed. Please check details or connection.');
      notifyListeners();
      return false;
    } catch (e) {
      _isLoading = false;
      _errorMessage = 'An unexpected error occurred during registration.';
      notifyListeners();
      return false;
    }
  }

  String _extractDioError(DioException e, String defaultMessage) {
    if (e.response?.data != null) {
      final data = e.response!.data;
      if (data is Map) {
        if (data['message'] != null && data['message'].toString().trim().isNotEmpty) {
          return data['message'].toString();
        }
        if (data['errors'] != null && data['errors'] is Map) {
          final errors = data['errors'] as Map;
          if (errors.isNotEmpty) {
            final firstVal = errors.values.first;
            if (firstVal is List && firstVal.isNotEmpty) {
              return firstVal.first.toString();
            } else if (firstVal != null) {
              return firstVal.toString();
            }
          }
        }
        if (data['error'] != null) {
          return data['error'].toString();
        }
      } else if (data is String && data.isNotEmpty && !data.contains('<!DOCTYPE')) {
        return data;
      }
    }

    if (e.type == DioExceptionType.connectionTimeout ||
        e.type == DioExceptionType.receiveTimeout ||
        e.type == DioExceptionType.sendTimeout) {
      return 'Connection timed out. Please check your internet connection.';
    }
    if (e.type == DioExceptionType.connectionError) {
      return 'Could not reach server. Please check your internet connection.';
    }
    if (e.response?.statusCode != null) {
      if (e.response!.statusCode == 401) {
        return 'Invalid email or password.';
      }
      if (e.response!.statusCode == 403) {
        return 'Access denied. Your account may be inactive.';
      }
      if (e.response!.statusCode == 404) {
        return 'Server route not found.';
      }
      if (e.response!.statusCode == 500) {
        return 'Server error (500). Please try again later.';
      }
      return 'Server error (${e.response!.statusCode}). Please try again.';
    }

    return defaultMessage;
  }

  Future<void> fetchUser() async {
    try {
      final response = await ApiClient.instance.get(ApiConstants.user);
      final userRaw = response.data['user'];
      final userData = userRaw is Map ? Map<String, dynamic>.from(userRaw) : <String, dynamic>{};
      _user = User.fromJson(userData);
      final backendRole = (response.data['role'] ?? _user!.role).toString().toLowerCase();
      _user = User(
        id: _user!.id,
        name: _user!.name.trim().isNotEmpty ? _user!.name : (backendRole == 'admin' ? 'Admin' : 'User'),
        email: _user!.email,
        role: backendRole,
        phone: _user!.phone,
        companyName: _user!.companyName,
        address: _user!.address,
        salesmanId: _user!.salesmanId,
      );
    } catch (_) {
      // If fetching user fails (e.g., token expired), logout
      await logout();
    }
  }

  Future<void> logout() async {
    final currentRole = _user?.role;
    try {
      await NotificationService.instance.removeToken(role: currentRole);
    } catch (_) {}

    try {
      if (_token != null) {
        await ApiClient.instance.post(ApiConstants.logout);
      }
    } catch (_) {
      // Ignore errors on logout
    }

    _token = null;
    _user = null;
    _errorMessage = null;
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    
    notifyListeners();
  }
}
