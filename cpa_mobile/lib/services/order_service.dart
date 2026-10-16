import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';
import '../models/order_model.dart';

class PaginatedOrders {
  final List<Order> orders;
  final int currentPage;
  final int lastPage;
  final int total;

  PaginatedOrders({
    required this.orders,
    required this.currentPage,
    required this.lastPage,
    required this.total,
  });
}

class OrderService {
  Future<PaginatedOrders> getRetailerOrders({int page = 1}) async {
    try {
      final response = await ApiClient.instance.get(
        ApiConstants.retailerOrders,
        queryParameters: {'page': page},
      );

      final data = response.data;
      if (data is Map<String, dynamic>) {
        final List<dynamic> list = data['data'] ?? [];
        final orders = list
            .map((item) => Order.fromJson(item as Map<String, dynamic>))
            .toList();
        return PaginatedOrders(
          orders: orders,
          currentPage: data['current_page'] is int ? data['current_page'] : 1,
          lastPage: data['last_page'] is int ? data['last_page'] : 1,
          total: data['total'] is int ? data['total'] : orders.length,
        );
      }
      return PaginatedOrders(orders: [], currentPage: 1, lastPage: 1, total: 0);
    } catch (e) {
      return PaginatedOrders(orders: [], currentPage: 1, lastPage: 1, total: 0);
    }
  }

  Future<bool> checkout({
    required String customerName,
    required String phone,
    required List<Map<String, dynamic>> cart,
    required double total,
    String? notes,
  }) async {
    try {
      final payload = <String, dynamic>{
        'customer_name': customerName,
        'phone': phone,
        'cart': cart,
        'total': total,
      };
      if (notes != null && notes.trim().isNotEmpty) {
        payload['notes'] = notes.trim();
      }

      final response = await ApiClient.instance.post(
        ApiConstants.checkout,
        data: payload,
      );

      return response.statusCode == 200 || response.statusCode == 201;
    } catch (e) {
      return false;
    }
  }
}

