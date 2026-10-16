import 'package:flutter_test/flutter_test.dart';
import 'package:cpa_mobile/models/product_model.dart';
import 'package:cpa_mobile/models/cart_item_model.dart';
import 'package:cpa_mobile/models/order_model.dart';
import 'package:cpa_mobile/models/user_model.dart';

void main() {
  group('CPA Mobile Model Deserialization & Null Safety Tests', () {
    test('Product.fromJson parses safely with null or missing fields', () {
      final json = <String, dynamic>{
        'id': '12',
        'name': 'Azithromycin 500mg',
        'composition': null,
        'packing': null,
        'mrp': '120.50',
        'ptr': '85.20',
        'pts': null,
        'stock_qty': '50',
        'image_full_url': null,
        'company': null,
      };

      final product = Product.fromJson(json);
      expect(product.id, 12);
      expect(product.name, 'Azithromycin 500mg');
      expect(product.composition, '');
      expect(product.packing, '');
      expect(product.mrp, 120.50);
      expect(product.ptr, 85.20);
      expect(product.pts, 0.0);
      expect(product.stockQty, 50);
      expect(product.imageFullUrl, isNull);
      expect(product.company, isNull);
    });

    test('CartItem creates payload matching PWA & Admin schemas', () {
      final product = Product(
        id: 101,
        name: 'Paracetamol 650',
        composition: 'Paracetamol 650mg',
        packing: '10x10',
        mrp: 30.0,
        ptr: 22.0,
        pts: 20.0,
        stockQty: 100,
      );

      final item = CartItem(product: product, quantity: 3, unit: 'Box');
      expect(item.totalPrice, 66.0);

      final json = item.toJson();
      expect(json['id'], 101);
      expect(json['product_id'], 101);
      expect(json['qty'], 3);
      expect(json['quantity'], 3);
      expect(json['unit'], 'Box');
      expect(json['price'], 22.0);
      expect(json['subtotal'], 66.0);
    });

    test('Order.fromJson parses safely with null user and cart items', () {
      final json = <String, dynamic>{
        'id': 501,
        'user_id': '4',
        'customer_name': 'Sharma Medical Store',
        'phone': '9876543210',
        'total': '1550.00',
        'status': 'Pending',
        'cart': [
          {'name': 'Amoxicillin', 'qty': 2, 'unit': 'Box', 'price': 100}
        ],
        'created_at': '2026-10-16T10:00:00.000000Z',
      };

      final order = Order.fromJson(json);
      expect(order.id, 501);
      expect(order.userId, 4);
      expect(order.customerName, 'Sharma Medical Store');
      expect(order.phone, '9876543210');
      expect(order.total, 1550.0);
      expect(order.status, 'Pending');
      expect(order.cart.length, 1);
    });

    test('User.fromJson handles salesman and retailer attributes safely', () {
      final json = <String, dynamic>{
        'id': 15,
        'name': 'Rahul Verma',
        'email': 'rahul@example.com',
        'role': 'salesman',
        'phone': '9988776655',
        'company_name': null,
        'address': 'Civil Lines, Kanpur',
        'salesman_id': null,
      };

      final user = User.fromJson(json);
      expect(user.id, 15);
      expect(user.name, 'Rahul Verma');
      expect(user.role, 'salesman');
      expect(user.companyName, isNull);
      expect(user.phone, '9988776655');
    });
  });
}

