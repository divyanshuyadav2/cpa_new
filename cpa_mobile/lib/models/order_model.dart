class Order {
  final int id;
  final String customerName;
  final String phone;
  final double total;
  final String status;
  final List<dynamic> cart;
  final String createdAt;

  Order({
    required this.id,
    required this.customerName,
    required this.phone,
    required this.total,
    required this.status,
    required this.cart,
    required this.createdAt,
  });

  factory Order.fromJson(Map<String, dynamic> json) {
    return Order(
      id: json['id'],
      customerName: json['customer_name'],
      phone: json['phone'],
      total: double.parse(json['total'].toString()),
      status: json['status'],
      cart: json['cart'] ?? [],
      createdAt: json['created_at'],
    );
  }
}
