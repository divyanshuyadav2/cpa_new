import 'product_model.dart';

class CartItem {
  final Product product;
  int quantity;
  String unit; // 'Box' or 'Strip'

  CartItem({
    required this.product,
    this.quantity = 1,
    this.unit = 'Box',
  });

  int get factor => unit == 'Box' ? product.stripsPerBox : 1;
  double get unitPrice => product.ptr * factor;
  double get totalPrice => unitPrice * quantity;

  factory CartItem.fromJson(Map<String, dynamic> json) {
    return CartItem(
      product: Product.fromJson(json['product'] as Map<String, dynamic>),
      quantity: json['quantity'] is int
          ? json['quantity']
          : (int.tryParse(json['quantity']?.toString() ?? '1') ?? 1),
      unit: json['unit']?.toString() ?? 'Box',
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': product.id,
      'product_id': product.id,
      'name': product.name,
      'product_name': product.name,
      'packing': product.packing,
      'unit': unit,
      'factor': factor,
      'strips_per_box': product.stripsPerBox,
      'qty': quantity,
      'quantity': quantity,
      'price': unitPrice,
      'unit_price': unitPrice,
      'subtotal': totalPrice,
      'total': totalPrice,
      'product': product.toJson(),
    };
  }
}

