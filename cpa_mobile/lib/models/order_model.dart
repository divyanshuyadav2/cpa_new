import 'user_model.dart';

class Order {
  final int id;
  final int? userId;
  final String customerName;
  final String phone;
  final double total;
  final String status;
  final List<dynamic> cart;
  final String createdAt;
  final User? user;

  Order({
    required this.id,
    this.userId,
    required this.customerName,
    required this.phone,
    required this.total,
    required this.status,
    required this.cart,
    required this.createdAt,
    this.user,
  });

  factory Order.fromJson(Map<String, dynamic> json) {
    return Order(
      id: json['id'] is int ? json['id'] : (int.tryParse(json['id']?.toString() ?? '0') ?? 0),
      userId: json['user_id'] is int ? json['user_id'] : int.tryParse(json['user_id']?.toString() ?? ''),
      customerName: json['customer_name']?.toString() ?? 'Retailer',
      phone: json['phone']?.toString() ?? '',
      total: double.tryParse(json['total']?.toString() ?? '0') ?? 0.0,
      status: json['status']?.toString() ?? 'Pending',
      cart: json['cart'] is List ? (json['cart'] as List) : [],
      createdAt: json['created_at']?.toString() ?? '',
      user: json['user'] != null && json['user'] is Map<String, dynamic>
          ? User.fromJson(json['user'])
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'user_id': userId,
      'customer_name': customerName,
      'phone': phone,
      'total': total,
      'status': status,
      'cart': cart,
      'created_at': createdAt,
      'user': user?.toJson(),
    };
  }
}

