import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../providers/cart_provider.dart';
import '../../providers/auth_provider.dart';

class CartScreen extends StatelessWidget {
  const CartScreen({super.key});

  @override
  Widget build(BuildContext context) {
    final cart = context.watch<CartProvider>();
    final auth = context.read<AuthProvider>();

    if (cart.items.isEmpty) {
      return const Center(child: Text('Your cart is empty.'));
    }

    return Column(
      children: [
        Expanded(
          child: ListView.builder(
            itemCount: cart.items.length,
            itemBuilder: (context, index) {
              final cartItem = cart.items.values.toList()[index];
              return ListTile(
                title: Text(cartItem.product.name),
                subtitle: Text('₹${cartItem.product.ptr} x ${cartItem.quantity}'),
                trailing: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    IconButton(
                      icon: const Icon(Icons.remove_circle_outline),
                      onPressed: () {
                        cart.updateQuantity(cartItem.product.id, cartItem.quantity - 1);
                      },
                    ),
                    Text('${cartItem.quantity}', style: const TextStyle(fontSize: 16)),
                    IconButton(
                      icon: const Icon(Icons.add_circle_outline),
                      onPressed: () {
                        cart.updateQuantity(cartItem.product.id, cartItem.quantity + 1);
                      },
                    ),
                  ],
                ),
              );
            },
          ),
        ),
        Container(
          padding: const EdgeInsets.all(20),
          decoration: BoxDecoration(
            color: Colors.white,
            boxShadow: [
              BoxShadow(
                color: Colors.grey.withOpacity(0.2),
                spreadRadius: 1,
                blurRadius: 5,
                offset: const Offset(0, -3),
              ),
            ],
          ),
          child: Row(
            mainAxisAlignment: MainAxisAlignment.spaceBetween,
            children: [
              Text(
                'Total: ₹${cart.totalAmount.toStringAsFixed(2)}',
                style: const TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
              ),
              ElevatedButton(
                onPressed: cart.isCheckingOut
                    ? null
                    : () async {
                        final success = await cart.checkout(
                          auth.user?.name ?? 'Retailer',
                          auth.user?.phone ?? 'N/A',
                        );
                        if (success && context.mounted) {
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(content: Text('Order placed successfully!')),
                          );
                        } else if (context.mounted) {
                          ScaffoldMessenger.of(context).showSnackBar(
                            const SnackBar(content: Text('Failed to place order.')),
                          );
                        }
                      },
                child: cart.isCheckingOut
                    ? const SizedBox(width: 20, height: 20, child: CircularProgressIndicator(color: Colors.white))
                    : const Text('Checkout'),
              ),
            ],
          ),
        ),
      ],
    );
  }
}
