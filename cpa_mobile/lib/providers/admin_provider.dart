import 'package:flutter/material.dart';
import 'package:dio/dio.dart';
import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';

class AdminProvider with ChangeNotifier {
  List<dynamic> _orders = [];
  Map<String, dynamic> _stats = {};
  List<dynamic> _billers = [];
  bool _isLoading = false;
  String? _errorMessage;
  String _selectedStatus = 'all';
  String _searchQuery = '';

  List<dynamic> get orders => _orders;
  Map<String, dynamic> get stats => _stats;
  List<dynamic> get billers => _billers;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;
  String get selectedStatus => _selectedStatus;

  Future<void> init() async {
    await Future.wait([
      loadOrders(),
      loadBillers(),
    ]);
  }

  Future<void> setStatusFilter(String status) async {
    _selectedStatus = status;
    await loadOrders();
  }

  Future<void> setSearchQuery(String query) async {
    _searchQuery = query;
    await loadOrders();
  }

  Future<void> loadOrders() async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final queryParams = <String, dynamic>{};
      if (_selectedStatus != 'all') {
        queryParams['status'] = _selectedStatus;
      }
      if (_searchQuery.trim().isNotEmpty) {
        queryParams['search'] = _searchQuery.trim();
      }

      final response = await ApiClient.instance.get(
        ApiConstants.adminOrders,
        queryParameters: queryParams,
      );

      _orders = response.data['orders']['data'] ?? [];
      _stats = response.data['stats'] ?? {};
      _isLoading = false;
      notifyListeners();
    } on DioException catch (e) {
      _isLoading = false;
      _errorMessage = e.response?.data?['message']?.toString() ?? 'Failed to load orders.';
      notifyListeners();
    } catch (_) {
      _isLoading = false;
      _errorMessage = 'An error occurred while loading orders.';
      notifyListeners();
    }
  }

  Future<void> loadBillers() async {
    try {
      final response = await ApiClient.instance.get(ApiConstants.adminBillers);
      _billers = response.data['billers'] ?? [];
      notifyListeners();
    } catch (_) {
      // Ignore
    }
  }

  Future<bool> assignBiller(int orderId, int? billerId) async {
    try {
      final response = await ApiClient.instance.patch(
        ApiConstants.adminAssignBiller(orderId),
        data: {'biller_id': billerId},
      );

      final updatedOrder = response.data['order'];
      final index = _orders.indexWhere((o) => o['id'] == orderId);
      if (index != -1 && updatedOrder != null) {
        _orders[index] = updatedOrder;
        notifyListeners();
      }
      return true;
    } catch (_) {
      return false;
    }
  }

  Future<bool> updateOrderStatus(int orderId, String newStatus) async {
    try {
      final response = await ApiClient.instance.patch(
        ApiConstants.adminUpdateOrderStatus(orderId),
        data: {'status': newStatus},
      );

      final updatedOrder = response.data['order'];
      final index = _orders.indexWhere((o) => o['id'] == orderId);
      if (index != -1 && updatedOrder != null) {
        _orders[index] = updatedOrder;
        notifyListeners();
      }
      return true;
    } catch (_) {
      return false;
    }
  }

  Future<bool> createBiller({
    required String name,
    required String email,
    required String phone,
    required String password,
  }) async {
    try {
      await ApiClient.instance.post(
        ApiConstants.adminCreateBiller,
        data: {
          'name': name,
          'email': email,
          'phone': phone,
          'password': password,
        },
      );
      await loadBillers();
      return true;
    } catch (_) {
      return false;
    }
  }
}
