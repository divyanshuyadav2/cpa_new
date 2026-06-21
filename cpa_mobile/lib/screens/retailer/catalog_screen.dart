import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:dio/dio.dart';
import '../../core/api/api_client.dart';
import '../../core/constants/api_constants.dart';
import '../../models/product_model.dart';
import '../../providers/cart_provider.dart';

class CatalogScreen extends StatefulWidget {
  const CatalogScreen({super.key});

  @override
  State<CatalogScreen> createState() => _CatalogScreenState();
}

class _CatalogScreenState extends State<CatalogScreen> {
  List<Product> _products = [];
  bool _isLoading = true;

  @override
  void initState() {
    super.initState();
    _fetchProducts();
  }

  Future<void> _fetchProducts() async {
    try {
      final response = await ApiClient.instance.get(ApiConstants.products);
      final List<dynamic> data = response.data['data']; // Assuming paginated response structure
      setState(() {
        _products = data.map((json) => Product.fromJson(json)).toList();
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

    if (_products.isEmpty) {
      return const Center(child: Text('No products available.'));
    }

    return ListView.builder(
      padding: const EdgeInsets.all(8.0),
      itemCount: _products.length,
      itemBuilder: (context, index) {
        final product = _products[index];
        return Card(
          elevation: 2,
          margin: const EdgeInsets.symmetric(vertical: 8),
          child: ListTile(
            leading: product.imageFullUrl != null
                ? Image.network(product.imageFullUrl!, width: 50, height: 50, fit: BoxFit.cover,
                  errorBuilder: (context, error, stackTrace) => const Icon(Icons.image_not_supported, size: 50),
                )
                : const Icon(Icons.medical_services, size: 50),
            title: Text(product.name, style: const TextStyle(fontWeight: FontWeight.bold)),
            subtitle: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                Text(product.composition),
                Text('PTR: ₹${product.ptr} | Pack: ${product.packing}', style: const TextStyle(color: Colors.green)),
              ],
            ),
            trailing: IconButton(
              icon: const Icon(Icons.add_shopping_cart, color: Color(0xFF0D47A1)),
              onPressed: () {
                context.read<CartProvider>().addItem(product);
                ScaffoldMessenger.of(context).showSnackBar(
                  SnackBar(
                    content: Text('${product.name} added to cart'),
                    duration: const Duration(seconds: 1),
                  ),
                );
              },
            ),
          ),
        );
      },
    );
  }
}
