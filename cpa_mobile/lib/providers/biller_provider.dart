import 'package:flutter/material.dart';
import 'package:dio/dio.dart';
import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';

class BillerProvider with ChangeNotifier {
  List<dynamic> _orders = [];
  Map<String, dynamic> _stats = {};
  bool _isLoading = false;
  String? _errorMessage;
  String _selectedStatus = 'all';

  List<dynamic> get orders => _orders;
  Map<String, dynamic> get stats => _stats;
  bool get isLoading => _isLoading;
  String? get errorMessage => _errorMessage;
  String get selectedStatus => _selectedStatus;

  Future<void> init() async {
    await loadOrders();
  }

  Future<void> setStatusFilter(String status) async {
    _selectedStatus = status;
    await loadOrders();
  }

  Future<void> loadOrders() async {
    _isLoading = true;
    _errorMessage = null;
    notifyListeners();

    try {
      final queryParams = <String, dynamic>{};
      if (_selectedStatus != 'all') {
        queryParams['billing_status'] = _selectedStatus;
      }

      final response = await ApiClient.instance.get(
        ApiConstants.billerOrders,
        queryParameters: queryParams,
      );

      _orders = response.data['orders']['data'] ?? [];
      _stats = response.data['stats'] ?? {};
      _isLoading = false;
      notifyListeners();
    } on DioException catch (e) {
      _isLoading = false;
      _errorMessage = e.response?.data?['message']?.toString() ?? 'Failed to load assigned orders.';
      notifyListeners();
    } catch (_) {
      _isLoading = false;
      _errorMessage = 'An error occurred while loading orders.';
      notifyListeners();
    }
  }

  Future<bool> updateBilling({
    required int orderId,
    required String invoiceNo,
    required String billingStatus,
    String? notes,
  }) async {
    try {
      final response = await ApiClient.instance.patch(
        ApiConstants.billerUpdateStatus(orderId),
        data: {
          'invoice_no': invoiceNo,
          'billing_status': billingStatus,
          'billing_notes': notes,
        },
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
}
