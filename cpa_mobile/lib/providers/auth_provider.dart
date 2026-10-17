import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import 'package:dio/dio.dart';
import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';
import '../models/user_model.dart';

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
        data: FormData.fromMap({
          'email': email,
          'password': password,
        }),
      );

      _token = response.data['token'];
      _user = User.fromJson(response.data['user']);
      
      // Override role from backend correctly
      _user = User(
        id: _user!.id,
        name: _user!.name,
        email: _user!.email,
        role: response.data['role'] ?? _user!.role,
        phone: _user!.phone,
        companyName: _user!.companyName,
        address: _user!.address,
      );

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', _token!);

      _isLoading = false;
      notifyListeners();
      return true;
    } on DioException catch (e) {
      _isLoading = false;
      if (e.response?.data is Map && e.response?.data['message'] != null) {
        _errorMessage = e.response!.data['message'].toString();
      } else {
        _errorMessage = 'Login failed. Please check your credentials or connection.';
      }
      notifyListeners();
      return false;
    } catch (_) {
      _isLoading = false;
      _errorMessage = 'An unexpected error occurred. Please try again.';
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
  }) async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final response = await ApiClient.instance.post(
        ApiConstants.register,
        data: FormData.fromMap({
          'name': name,
          'email': email,
          'password': password,
          'phone': phone,
          'company_name': companyName,
          'address': address,
          'role': 'retailer',
        }),
      );

      _token = response.data['token'];
      _user = User.fromJson(response.data['user']);
      _user = User(
        id: _user!.id,
        name: _user!.name,
        email: _user!.email,
        role: response.data['role'] ?? _user!.role,
        phone: _user!.phone,
        companyName: _user!.companyName,
        address: _user!.address,
      );

      final prefs = await SharedPreferences.getInstance();
      await prefs.setString('auth_token', _token!);

      _isLoading = false;
      notifyListeners();
      return true;
    } on DioException catch (e) {
      _isLoading = false;
      if (e.response?.data is Map && e.response?.data['message'] != null) {
        _errorMessage = e.response!.data['message'].toString();
      } else {
        _errorMessage = 'Registration failed. Please check details or connection.';
      }
      notifyListeners();
      return false;
    } catch (_) {
      _isLoading = false;
      _errorMessage = 'An unexpected error occurred during registration.';
      notifyListeners();
      return false;
    }
  }

  Future<void> fetchUser() async {
    try {
      final response = await ApiClient.instance.get(ApiConstants.user);
      _user = User.fromJson(response.data['user']);
      _user = User(
        id: _user!.id,
        name: _user!.name,
        email: _user!.email,
        role: response.data['role'] ?? _user!.role,
        phone: _user!.phone,
        companyName: _user!.companyName,
        address: _user!.address,
      );
    } catch (_) {
      // If fetching user fails (e.g., token expired), logout
      await logout();
    }
  }

  Future<void> logout() async {
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
