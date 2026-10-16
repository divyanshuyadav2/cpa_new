import 'package:flutter/material.dart';
import '../models/user_model.dart';
import '../models/order_model.dart';
import '../services/salesman_service.dart';

class SalesmanProvider with ChangeNotifier {
  final SalesmanService _salesmanService;

  List<User> _retailers = [];
  List<Order> _orders = [];
  bool _isLoading = false;
  bool _isUpdatingStatus = false;
  String? _errorMessage;

  String _selectedStatusFilter = 'All'; // 'All', 'Pending', 'Confirmed', 'Dispatched', 'Delivered'
  String _searchQuery = '';
  int _currentPage = 1;
  int _lastPage = 1;

  SalesmanProvider({SalesmanService? salesmanService})
      : _salesmanService = salesmanService ?? SalesmanService();

  List<User> get retailers => _retailers;
  bool get isLoading => _isLoading;
  bool get isUpdatingStatus => _isUpdatingStatus;
  String? get errorMessage => _errorMessage;
  String get selectedStatusFilter => _selectedStatusFilter;
  String get searchQuery => _searchQuery;
  int get currentPage => _currentPage;
  int get lastPage => _lastPage;
  bool get hasMore => _currentPage < _lastPage;

  // Filtered orders based on selectedStatusFilter and searchQuery
  List<Order> get filteredOrders {
    return _orders.where((order) {
      final matchesStatus = _selectedStatusFilter == 'All' ||
          order.status.toLowerCase() == _selectedStatusFilter.toLowerCase();

      final q = _searchQuery.trim().toLowerCase();
      final matchesSearch = q.isEmpty ||
          order.id.toString().contains(q) ||
          order.customerName.toLowerCase().contains(q) ||
          order.phone.toLowerCase().contains(q) ||
          (order.user?.companyName?.toLowerCase().contains(q) ?? false);

      return matchesStatus && matchesSearch;
    }).toList();
  }

  // KPI Metrics calculated from all loaded orders
  int get totalOrdersCount => _orders.length;
  int get pendingOrdersCount =>
      _orders.where((o) => o.status.toLowerCase() == 'pending').length;
  int get deliveredOrdersCount =>
      _orders.where((o) => o.status.toLowerCase() == 'delivered').length;

  Future<void> init() async {
    await fetchRetailers();
    await fetchOrders(resetPage: true);
  }

  Future<void> fetchRetailers() async {
    try {
      _retailers = await _salesmanService.getAssignedRetailers();
      notifyListeners();
    } catch (_) {}
  }

  Future<void> fetchOrders({bool resetPage = false}) async {
    if (resetPage) {
      _currentPage = 1;
      _isLoading = true;
      _errorMessage = null;
      notifyListeners();
    }

    try {
      final result = await _salesmanService.getOrders(page: _currentPage);
      if (resetPage) {
        _orders = result.orders;
      } else {
        _orders.addAll(result.orders);
      }
      _currentPage = result.currentPage;
      _lastPage = result.lastPage;
    } catch (_) {
      _errorMessage = 'Failed to load salesman data. Please pull down to refresh.';
    } finally {
      _isLoading = false;
      notifyListeners();
    }
  }

  void setStatusFilter(String status) {
    if (_selectedStatusFilter == status) return;
    _selectedStatusFilter = status;
    notifyListeners();
  }

  void setSearchQuery(String query) {
    _searchQuery = query;
    notifyListeners();
  }

  Future<bool> updateOrderStatus(int orderId, String newStatus) async {
    _isUpdatingStatus = true;
    notifyListeners();

    final success = await _salesmanService.updateOrderStatus(orderId, newStatus);
    if (success) {
      // Update local state directly for responsive UI
      final index = _orders.indexWhere((o) => o.id == orderId);
      if (index != -1) {
        final current = _orders[index];
        _orders[index] = Order(
          id: current.id,
          userId: current.userId,
          customerName: current.customerName,
          phone: current.phone,
          total: current.total,
          status: newStatus,
          cart: current.cart,
          createdAt: current.createdAt,
          user: current.user,
        );
      }
    }

    _isUpdatingStatus = false;
    notifyListeners();
    return success;
  }
}
