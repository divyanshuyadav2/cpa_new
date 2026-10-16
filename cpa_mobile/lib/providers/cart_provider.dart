import 'dart:convert';
import 'package:flutter/material.dart';
import 'package:shared_preferences/shared_preferences.dart';
import '../models/product_model.dart';
import '../models/cart_item_model.dart';
import '../services/order_service.dart';

class CartProvider with ChangeNotifier {
  static const String _storageKey = 'cpa_retailer_cart_items_v1';
  final OrderService _orderService;
  final Map<int, CartItem> _items = {};
  bool _isCheckingOut = false;
  String? _errorMessage;
  bool _isLoaded = false;

  CartProvider({OrderService? orderService})
      : _orderService = orderService ?? OrderService();

  Map<int, CartItem> get items => {..._items};
  int get itemCount => _items.length;
  int get totalUnits => _items.values.fold(0, (sum, item) => sum + item.quantity);
  bool get isCheckingOut => _isCheckingOut;
  String? get errorMessage => _errorMessage;
  bool get isLoaded => _isLoaded;

  double get totalAmount {
    var total = 0.0;
    _items.forEach((_, cartItem) {
      total += cartItem.totalPrice;
    });
    return total;
  }

  /// Initialize and load saved cart from local storage
  Future<void> init() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final savedJson = prefs.getString(_storageKey);
      if (savedJson != null && savedJson.isNotEmpty) {
        final List<dynamic> decoded = jsonDecode(savedJson);
        _items.clear();
        for (final itemMap in decoded) {
          try {
            final cartItem = CartItem.fromJson(itemMap as Map<String, dynamic>);
            _items[cartItem.product.id] = cartItem;
          } catch (_) {}
        }
      }
    } catch (_) {
      // Ignore cache load failure
    } finally {
      _isLoaded = true;
      notifyListeners();
    }
  }

  Future<void> _saveCart() async {
    try {
      final prefs = await SharedPreferences.getInstance();
      final list = _items.values.map((item) => item.toJson()).toList();
      await prefs.setString(_storageKey, jsonEncode(list));
    } catch (_) {
      // Ignore cache save error
    }
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
    _saveCart();
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
      _saveCart();
      notifyListeners();
    }
  }

  void removeItem(int productId) {
    _items.remove(productId);
    _saveCart();
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
      _saveCart();
      notifyListeners();
    }
  }

  void clear() {
    _items.clear();
    _errorMessage = null;
    _saveCart();
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
    final result = await _orderService.checkout(
      customerName: customerName,
      phone: phone,
      cart: cartPayload,
      total: totalAmount,
      notes: notes,
    );

    _isCheckingOut = false;
    if (result.isSuccess) {
      clear();
      return true;
    } else {
      _errorMessage = result.errorMessage ?? 'Failed to place order. Please try again.';
      notifyListeners();
      return false;
    }
  }
}
