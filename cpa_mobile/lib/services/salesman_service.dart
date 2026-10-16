import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';
import '../models/user_model.dart';
import '../models/order_model.dart';
import 'order_service.dart';

class SalesmanService {
  Future<List<User>> getAssignedRetailers() async {
    try {
      final response = await ApiClient.instance.get(ApiConstants.salesmanRetailers);
      if (response.data is List) {
        return (response.data as List)
            .map((item) => User.fromJson(item as Map<String, dynamic>))
            .toList();
      }
      return [];
    } catch (e) {
      return [];
    }
  }

  Future<PaginatedOrders> getOrders({int page = 1}) async {
    try {
      final response = await ApiClient.instance.get(
        ApiConstants.salesmanOrders,
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

  Future<bool> updateOrderStatus(int orderId, String newStatus) async {
    try {
      final response = await ApiClient.instance.patch(
        ApiConstants.salesmanOrderStatus(orderId),
        data: {'status': newStatus},
      );
      return response.statusCode == 200;
    } catch (e) {
      return false;
    }
  }
}
