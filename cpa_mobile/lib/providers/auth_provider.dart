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

  User? get user => _user;
  String? get token => _token;
  bool get isAuthenticated => _token != null;
  bool get isLoading => _isLoading;
  
  bool get isAdmin => _user?.role == 'admin';
  bool get isSalesman => _user?.role == 'salesman';
  bool get isRetailer => _user?.role == 'retailer';

  Future<void> init() async {
    final prefs = await SharedPreferences.getInstance();
    _token = prefs.getString('auth_token');
    if (_token != null) {
      await fetchUser();
    }
    notifyListeners();
  }

  Future<bool> login(String email, String password, String type) async {
    _isLoading = true;
    notifyListeners();

    try {
      final response = await ApiClient.instance.post(
        ApiConstants.login,
        data: {
          'email': email,
          'password': password,
          'type': type,
        },
      );

      _token = response.data['token'];
      _user = User.fromJson(response.data['user']);
      
      // Override role from backend correctly
      _user = User(
        id: _user!.id,
        name: _user!.name,
        email: _user!.email,
        role: response.data['role'],
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
        role: response.data['role'],
      );
    } catch (e) {
      // If fetching user fails (e.g., token expired), logout
      await logout();
    }
  }

  Future<void> logout() async {
    try {
      if (_token != null) {
        await ApiClient.instance.post(ApiConstants.logout);
      }
    } catch (e) {
      // Ignore errors on logout
    }

    _token = null;
    _user = null;
    final prefs = await SharedPreferences.getInstance();
    await prefs.remove('auth_token');
    
    notifyListeners();
  }
}
