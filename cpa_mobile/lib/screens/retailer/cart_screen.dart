import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../providers/cart_provider.dart';
import '../../providers/auth_provider.dart';

class CartScreen extends StatefulWidget {
  const CartScreen({super.key});

  @override
  State<CartScreen> createState() => _CartScreenState();
}

class _CartScreenState extends State<CartScreen> {
  final _nameController = TextEditingController();
  final _phoneController = TextEditingController();
  final _notesController = TextEditingController();
  bool _initializedUser = false;

  @override
  void didChangeDependencies() {
    super.didChangeDependencies();
    if (!_initializedUser) {
      final auth = context.read<AuthProvider>();
      _nameController.text = auth.user?.companyName?.isNotEmpty == true
          ? auth.user!.companyName!
          : (auth.user?.name ?? 'Retailer Store');
      _phoneController.text = auth.user?.phone ?? '';
      _initializedUser = true;
    }
  }

  @override
  void dispose() {
    _nameController.dispose();
    _phoneController.dispose();
    _notesController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final cart = context.watch<CartProvider>();

    if (cart.items.isEmpty) {
      return Center(
        child: Padding(
          padding: const EdgeInsets.all(32.0),
          child: Column(
            mainAxisAlignment: MainAxisAlignment.center,
            children: [
              Icon(Icons.remove_shopping_cart_outlined, size: 80, color: Colors.grey.shade400),
              const SizedBox(height: 16),
              const Text(
                'Your cart is empty',
                style: TextStyle(fontSize: 20, fontWeight: FontWeight.bold),
              ),
              const SizedBox(height: 8),
              Text(
                'Explore the catalog and add medicines to your order.',
                textAlign: TextAlign.center,
                style: TextStyle(color: Colors.grey.shade600),
              ),
            ],
          ),
        ),
      );
    }

    final cartItems = cart.items.values.toList();

    return Column(
      children: [
        // Items List — shrinks when keyboard opens
        Expanded(
          child: ListView.separated(
            padding: const EdgeInsets.all(12),
            itemCount: cartItems.length,
            separatorBuilder: (_, __) => const SizedBox(height: 8),
            itemBuilder: (context, index) {
              final item = cartItems[index];
              return Card(
                elevation: 1,
                shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                child: Padding(
                  padding: const EdgeInsets.all(12),
                  child: Row(
                    crossAxisAlignment: CrossAxisAlignment.center,
                    children: [
                      // Product info
                      Expanded(
                        child: Column(
                          crossAxisAlignment: CrossAxisAlignment.start,
                          children: [
                            Text(
                              item.product.name,
                              style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
                            ),
                            const SizedBox(height: 4),
                            Text(
                              'Pack: ${item.product.packing.isNotEmpty ? item.product.packing : 'Std'} | PTR: ₹${item.product.ptr.toStringAsFixed(2)}',
                              style: TextStyle(fontSize: 12, color: Colors.grey.shade700),
                            ),
                            const SizedBox(height: 6),
                            // Unit selector chip
                            Row(
                              children: [
                                const Text('Unit: ', style: TextStyle(fontSize: 12, color: Colors.grey)),
                                DropdownButton<String>(
                                  value: item.unit,
                                  isDense: true,
                                  underline: const SizedBox(),
                                  style: const TextStyle(
                                    fontSize: 13,
                                    fontWeight: FontWeight.w600,
                                    color: Color(0xFF0D47A1),
                                  ),
                                  items: const [
                                    DropdownMenuItem(value: 'Box', child: Text('Box')),
                                    DropdownMenuItem(value: 'Strip', child: Text('Strip')),
                                  ],
                                  onChanged: (newUnit) {
                                    if (newUnit != null) {
                                      cart.updateUnit(item.product.id, newUnit);
                                    }
                                  },
                                ),
                              ],
                            ),
                          ],
                        ),
                      ),

                      // Stepper & Subtotal
                      Column(
                        crossAxisAlignment: CrossAxisAlignment.end,
                        children: [
                          Text(
                            '₹${item.totalPrice.toStringAsFixed(2)}',
                            style: const TextStyle(
                              fontSize: 16,
                              fontWeight: FontWeight.bold,
                              color: Color(0xFF2E7D32),
                            ),
                          ),
                          const SizedBox(height: 8),
                          Row(
                            mainAxisSize: MainAxisSize.min,
                            children: [
                              IconButton(
                                icon: const Icon(Icons.remove_circle_outline),
                                iconSize: 22,
                                color: Colors.grey.shade700,
                                padding: EdgeInsets.zero,
                                constraints: const BoxConstraints(),
                                onPressed: () {
                                  cart.updateQuantity(item.product.id, item.quantity - 1);
                                },
                              ),
                              Padding(
                                padding: const EdgeInsets.symmetric(horizontal: 10),
                                child: Text(
                                  '${item.quantity}',
                                  style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
                                ),
                              ),
                              IconButton(
                                icon: const Icon(Icons.add_circle_outline),
                                iconSize: 22,
                                color: const Color(0xFF0D47A1),
                                padding: EdgeInsets.zero,
                                constraints: const BoxConstraints(),
                                onPressed: () {
                                  cart.updateQuantity(item.product.id, item.quantity + 1);
                                },
                              ),
                            ],
                          ),
                        ],
                      ),
                    ],
                  ),
                ),
              );
            },
          ),
        ),

        // Checkout Summary Sheet
        Container(
          padding: const EdgeInsets.all(16),
          decoration: BoxDecoration(
            color: Colors.white,
            borderRadius: const BorderRadius.vertical(top: Radius.circular(20)),
            boxShadow: [
              BoxShadow(
                color: Colors.black.withValues(alpha: 0.08),
                blurRadius: 10,
                offset: const Offset(0, -4),
              ),
            ],
          ),
          child: SafeArea(
            top: false,
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                // Order Form Fields
                Row(
                  children: [
                    Expanded(
                      child: TextField(
                        controller: _nameController,
                        decoration: InputDecoration(
                          labelText: 'Contact / Shop Name',
                          isDense: true,
                          contentPadding: const EdgeInsets.symmetric(horizontal: 10, vertical: 8),
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        ),
                      ),
                    ),
                    const SizedBox(width: 8),
                    Expanded(
                      child: TextField(
                        controller: _phoneController,
                        keyboardType: TextInputType.phone,
                        decoration: InputDecoration(
                          labelText: 'Phone',
                          isDense: true,
                          contentPadding: const EdgeInsets.symmetric(horizontal: 10, vertical: 8),
                          border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                        ),
                      ),
                    ),
                  ],
                ),
                const SizedBox(height: 8),
                TextField(
                  controller: _notesController,
                  decoration: InputDecoration(
                    labelText: 'Order Notes (Optional)',
                    hintText: 'e.g. Urgent delivery needed by evening',
                    isDense: true,
                    contentPadding: const EdgeInsets.symmetric(horizontal: 10, vertical: 8),
                    border: OutlineInputBorder(borderRadius: BorderRadius.circular(8)),
                  ),
                ),
                const SizedBox(height: 12),

                // Total and Checkout Button
                Row(
                  mainAxisAlignment: MainAxisAlignment.spaceBetween,
                  children: [
                    Column(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Text(
                          '${cart.itemCount} items (${cart.totalUnits} units)',
                          style: TextStyle(fontSize: 12, color: Colors.grey.shade600),
                        ),
                        Text(
                          '₹${cart.totalAmount.toStringAsFixed(2)}',
                          style: const TextStyle(
                            fontSize: 22,
                            fontWeight: FontWeight.w800,
                            color: Color(0xFF0D47A1),
                          ),
                        ),
                      ],
                    ),
                    ElevatedButton(
                      style: ElevatedButton.styleFrom(
                        backgroundColor: const Color(0xFF0D47A1),
                        padding: const EdgeInsets.symmetric(horizontal: 28, vertical: 14),
                        shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                      ),
                      onPressed: cart.isCheckingOut
                          ? null
                          : () async {
                              final name = _nameController.text.trim();
                              final phone = _phoneController.text.trim();

                              if (name.isEmpty || phone.isEmpty) {
                                ScaffoldMessenger.of(context).showSnackBar(
                                  const SnackBar(
                                    content: Text('Please enter your contact name and phone number'),
                                    behavior: SnackBarBehavior.floating,
                                  ),
                                );
                                return;
                              }

                              final success = await cart.checkout(
                                customerName: name,
                                phone: phone,
                                notes: _notesController.text.trim(),
                              );

                              if (success && context.mounted) {
                                _notesController.clear();
                                ScaffoldMessenger.of(context).showSnackBar(
                                  const SnackBar(
                                    content: Text('Order submitted successfully! 🎉'),
                                    backgroundColor: Color(0xFF2E7D32),
                                    behavior: SnackBarBehavior.floating,
                                  ),
                                );
                              } else if (context.mounted) {
                                ScaffoldMessenger.of(context).showSnackBar(
                                  SnackBar(
                                    content: Text(cart.errorMessage ?? 'Failed to place order'),
                                    backgroundColor: Colors.red.shade700,
                                    behavior: SnackBarBehavior.floating,
                                  ),
                                );
                              }
                            },
                      child: cart.isCheckingOut
                          ? const SizedBox(
                              width: 20,
                              height: 20,
                              child: CircularProgressIndicator(color: Colors.white, strokeWidth: 2),
                            )
                          : const Text(
                              'Place Order',
                              style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold),
                            ),
                    ),
                  ],
                ),
              ],
            ),
          ),
        ),
      ],
    );
  }
}
