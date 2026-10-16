import 'package:flutter/material.dart';
import '../models/product_model.dart';
import '../models/cart_item_model.dart';
import '../services/order_service.dart';

class CartProvider with ChangeNotifier {
  final OrderService _orderService;
  final Map<int, CartItem> _items = {};
  bool _isCheckingOut = false;
  String? _errorMessage;

  CartProvider({OrderService? orderService})
      : _orderService = orderService ?? OrderService();

  Map<int, CartItem> get items => {..._items};
  int get itemCount => _items.length;
  int get totalUnits => _items.values.fold(0, (sum, item) => sum + item.quantity);
  bool get isCheckingOut => _isCheckingOut;
  String? get errorMessage => _errorMessage;

  double get totalAmount {
    var total = 0.0;
    _items.forEach((_, cartItem) {
      total += cartItem.totalPrice;
    });
    return total;
  }

  void addItem(Product product, {String unit = 'Box', int quantity = 1}) {
    if (_items.containsKey(product.id)) {
      _items.update(
        product.id,
        (existingItem) => CartItem(
          product: existingItem.product,
          quantity: existingItem.quantity + quantity,
          unit: unit,
        ),
      );
    } else {
      _items.putIfAbsent(
        product.id,
        () => CartItem(product: product, quantity: quantity, unit: unit),
      );
    }
    notifyListeners();
  }

  void updateUnit(int productId, String unit) {
    if (_items.containsKey(productId)) {
      _items.update(
        productId,
        (existingItem) => CartItem(
          product: existingItem.product,
          quantity: existingItem.quantity,
          unit: unit,
        ),
      );
      notifyListeners();
    }
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
          unit: existingItem.unit,
        ),
      );
      notifyListeners();
    }
  }

  void clear() {
    _items.clear();
    _errorMessage = null;
    notifyListeners();
  }

  Future<bool> checkout({
    required String customerName,
    required String phone,
    String? notes,
  }) async {
    if (_items.isEmpty) return false;

    _isCheckingOut = true;
    _errorMessage = null;
    notifyListeners();

    final cartPayload = _items.values.map((item) => item.toJson()).toList();
    final success = await _orderService.checkout(
      customerName: customerName,
      phone: phone,
      cart: cartPayload,
      total: totalAmount,
      notes: notes,
    );

    _isCheckingOut = false;
    if (success) {
      clear();
    } else {
      _errorMessage = 'Failed to place order. Please try again.';
      notifyListeners();
    }

    return success;
  }
}
