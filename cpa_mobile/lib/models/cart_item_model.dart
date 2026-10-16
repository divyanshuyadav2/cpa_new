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

  double get totalPrice => product.ptr * quantity;

  Map<String, dynamic> toJson() {
    return {
      'id': product.id,
      'product_id': product.id,
      'name': product.name,
      'product_name': product.name,
      'packing': product.packing,
      'unit': unit,
      'qty': quantity,
      'quantity': quantity,
      'price': product.ptr,
      'subtotal': totalPrice,
      'total': totalPrice,
    };
  }
}

