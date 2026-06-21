import 'package:flutter/material.dart';
import '../models/product_model.dart';
import '../models/cart_item_model.dart';
import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';

class CartProvider with ChangeNotifier {
  final Map<int, CartItem> _items = {};
  bool _isCheckingOut = false;

  Map<int, CartItem> get items => {..._items};
  int get itemCount => _items.length;
  bool get isCheckingOut => _isCheckingOut;

  double get totalAmount {
    var total = 0.0;
    _items.forEach((key, cartItem) {
      total += cartItem.totalPrice;
    });
    return total;
  }

  void addItem(Product product) {
    if (_items.containsKey(product.id)) {
      _items.update(
        product.id,
        (existingItem) => CartItem(
          product: existingItem.product,
          quantity: existingItem.quantity + 1,
        ),
      );
    } else {
      _items.putIfAbsent(
        product.id,
        () => CartItem(product: product),
      );
    }
    notifyListeners();
  }

  void removeItem(int productId) {
    _items.remove(productId);
    notifyListeners();
  }

  void updateQuantity(int productId, int quantity) {
    if (quantity <= 0) {
      removeItem(productId);
      return;
    }
    
    if (_items.containsKey(productId)) {
      _items.update(
        productId,
        (existingItem) => CartItem(
          product: existingItem.product,
          quantity: quantity,
        ),
      );
      notifyListeners();
    }
  }

  void clear() {
    _items.clear();
    notifyListeners();
  }

  Future<bool> checkout(String customerName, String phone) async {
    if (_items.isEmpty) return false;
    
    _isCheckingOut = true;
    notifyListeners();

    try {
      final cartJson = _items.values.map((item) => item.toJson()).toList();
      
      await ApiClient.instance.post(
        ApiConstants.checkout,
        data: {
          'customer_name': customerName,
          'phone': phone,
          'cart': cartJson,
          'total': totalAmount,
        },
      );

      clear();
      _isCheckingOut = false;
      notifyListeners();
      return true;
    } catch (e) {
      _isCheckingOut = false;
      notifyListeners();
      return false;
    }
  }
}
