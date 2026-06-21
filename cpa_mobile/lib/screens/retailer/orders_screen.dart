import 'package:flutter/material.dart';
import 'package:dio/dio.dart';
import '../../core/api/api_client.dart';
import '../../core/constants/api_constants.dart';
import '../../models/order_model.dart';
import 'package:intl/intl.dart';

class OrdersScreen extends StatefulWidget {
  const OrdersScreen({super.key});

  @override
  State<OrdersScreen> createState() => _OrdersScreenState();
}

class _OrdersScreenState extends State<OrdersScreen> {
  List<Order> _orders = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchOrders();
  }

  Future<void> _fetchOrders() async {
    try {
      final response = await ApiClient.instance.get(ApiConstants.retailerOrders);
      final List<dynamic> data = response.data['data'];
      setState(() {
        _orders = data.map((json) => Order.fromJson(json)).toList();
        _isLoading = false;
      });
    } catch (e) {
      setState(() {
        _isLoading = false;
      });
    }
  }

  @override
  Widget build(BuildContext context) {
    if (_isLoading) {
      return const Center(child: CircularProgressIndicator());
    }

    if (_orders.isEmpty) {
      return const Center(child: Text('No orders found.'));
    }

    return ListView.builder(
      padding: const EdgeInsets.all(8.0),
      itemCount: _orders.length,
      itemBuilder: (context, index) {
        final order = _orders[index];
        final date = DateTime.parse(order.createdAt);
        return Card(
          elevation: 2,
          child: ListTile(
            leading: const Icon(Icons.receipt_long, size: 40, color: Color(0xFF0D47A1)),
            title: Text('Order #${order.id}'),
            subtitle: Text(DateFormat('dd MMM yyyy, hh:mm a').format(date)),
            trailing: Column(
              mainAxisAlignment: MainAxisAlignment.center,
              crossAxisAlignment: CrossAxisAlignment.end,
              children: [
                Text('₹${order.total}', style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                Text(order.status, style: TextStyle(
                  color: order.status.toLowerCase() == 'pending' ? Colors.orange : Colors.green,
                )),
              ],
            ),
          ),
        );
      },
    );
  }
}
