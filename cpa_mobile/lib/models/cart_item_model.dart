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
    Product prod;
    if (json['product'] != null && json['product'] is Map<String, dynamic>) {
      prod = Product.fromJson(json['product'] as Map<String, dynamic>);
    } else {
      prod = Product(
        id: json['id'] is int ? json['id'] : (int.tryParse(json['id']?.toString() ?? '0') ?? 0),
        name: json['name']?.toString() ?? json['product_name']?.toString() ?? 'Medicine Item',
        composition: '',
        packing: json['packing']?.toString() ?? '',
        mrp: 0.0,
        ptr: double.tryParse(json['price']?.toString() ?? '0') ?? 0.0,
        pts: 0.0,
        stockQty: 999,
      );
    }

    return CartItem(
      product: prod,
      quantity: json['quantity'] is int
          ? json['quantity']
          : (int.tryParse(json['quantity']?.toString() ?? json['qty']?.toString() ?? '1') ?? 1),
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

