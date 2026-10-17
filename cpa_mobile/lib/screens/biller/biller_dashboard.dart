import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../providers/auth_provider.dart';
import '../../providers/biller_provider.dart';

class BillerDashboard extends StatefulWidget {
  const BillerDashboard({super.key});

  @override
  State<BillerDashboard> createState() => _BillerDashboardState();
}

class _BillerDashboardState extends State<BillerDashboard> {
  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<BillerProvider>().init();
    });
  }

  @override
  Widget build(BuildContext context) {
    final biller = context.watch<BillerProvider>();
    final auth = context.watch<AuthProvider>();
    final stats = biller.stats;

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        title: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Billing Operator Console',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            Text(
              auth.user?.name ?? 'Billing Desk',
              style: const TextStyle(fontSize: 12, fontWeight: FontWeight.normal, color: Colors.white70),
            ),
          ],
        ),
        actions: [
          IconButton(
            tooltip: 'Refresh',
            icon: const Icon(Icons.refresh_rounded),
            onPressed: () => biller.loadOrders(),
          ),
          IconButton(
            tooltip: 'Sign Out',
            icon: const Icon(Icons.logout_rounded),
            onPressed: () async {
              final confirm = await showDialog<bool>(
                context: context,
                builder: (ctx) => AlertDialog(
                  title: const Text('Sign Out'),
                  content: const Text('Are you sure you want to log out?'),
                  actions: [
                    TextButton(onPressed: () => Navigator.pop(ctx, false), child: const Text('Cancel')),
                    ElevatedButton(
                      style: ElevatedButton.styleFrom(backgroundColor: Colors.red),
                      onPressed: () => Navigator.pop(ctx, true),
                      child: const Text('Log Out'),
                    ),
                  ],
                ),
              );
              if (confirm == true && context.mounted) {
                await context.read<AuthProvider>().logout();
              }
            },
          ),
        ],
      ),
      body: RefreshIndicator(
        onRefresh: () => biller.loadOrders(),
        child: CustomScrollView(
          slivers: [
            // Top Stats Summary
            SliverToBoxAdapter(
              child: Container(
                color: Colors.white,
                padding: const EdgeInsets.all(16),
                child: Row(
                  children: [
                    _buildStatCard('Assigned', '${stats['total_assigned'] ?? 0}', Colors.indigo, Icons.assignment_outlined),
                    const SizedBox(width: 10),
                    _buildStatCard('Pending Bill', '${stats['pending_billing'] ?? 0}', Colors.orange, Icons.pending_actions),
                    const SizedBox(width: 10),
                    _buildStatCard('Billed', '${stats['completed_billing'] ?? 0}', Colors.green, Icons.task_alt),
                  ],
                ),
              ),
            ),

            // Filter Tabs
            SliverToBoxAdapter(
              child: Container(
                color: Colors.white,
                padding: const EdgeInsets.fromLTRB(16, 0, 16, 12),
                child: Row(
                  children: [
                    _buildFilterChip(context, biller, 'all', 'All Assigned'),
                    _buildFilterChip(context, biller, 'in_progress', 'Pending Bill'),
                    _buildFilterChip(context, biller, 'billed', 'Billed Completed'),
                  ],
                ),
              ),
            ),

            // Orders List
            if (biller.isLoading)
              const SliverFillRemaining(
                child: Center(child: CircularProgressIndicator()),
              )
            else if (biller.orders.isEmpty)
              SliverFillRemaining(
                child: Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(Icons.receipt_long_outlined, size: 64, color: Colors.grey.shade400),
                      const SizedBox(height: 12),
                      Text(
                        'No assigned orders',
                        style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.grey.shade700),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        'Orders assigned by the Admin will appear here for billing.',
                        style: TextStyle(fontSize: 13, color: Colors.grey.shade500),
                      ),
                    ],
                  ),
                ),
              )
            else
              SliverPadding(
                padding: const EdgeInsets.all(16),
                sliver: SliverList(
                  delegate: SliverChildBuilderDelegate(
                    (context, index) {
                      final order = biller.orders[index];
                      return _buildBillerOrderCard(context, order, biller);
                    },
                    childCount: biller.orders.length,
                  ),
                ),
              ),
          ],
        ),
      ),
    );
  }

  Widget _buildStatCard(String label, String value, Color color, IconData icon) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 12),
        decoration: BoxDecoration(
          color: color.withOpacity(0.08),
          borderRadius: BorderRadius.circular(10),
          border: Border.all(color: color.withOpacity(0.2)),
        ),
        child: Column(
          children: [
            Icon(icon, color: color, size: 22),
            const SizedBox(height: 6),
            Text(
              value,
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold, color: color),
            ),
            Text(
              label,
              style: TextStyle(fontSize: 11, color: Colors.grey.shade700, fontWeight: FontWeight.w600),
            ),
          ],
        ),
      ),
    );
  }

  Widget _buildFilterChip(BuildContext context, BillerProvider biller, String value, String label) {
    final isSelected = biller.selectedStatus == value;
    return Padding(
      padding: const EdgeInsets.only(right: 8),
      child: FilterChip(
        selected: isSelected,
        label: Text(label),
        labelStyle: TextStyle(
          fontSize: 12,
          fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
          color: isSelected ? Colors.white : Colors.black87,
        ),
        backgroundColor: const Color(0xFFF1F5F9),
        selectedColor: const Color(0xFF0D47A1),
        checkmarkColor: Colors.white,
        padding: const EdgeInsets.symmetric(horizontal: 4, vertical: 2),
        onSelected: (_) => biller.setStatusFilter(value),
      ),
    );
  }

  Widget _buildBillerOrderCard(BuildContext context, dynamic order, BillerProvider biller) {
    final int id = order['id'];
    final String billingStatus = order['billing_status'] ?? 'pending';
    final String customerName = order['customer_name'] ?? 'Retailer';
    final String phone = order['phone'] ?? '';
    final String total = order['total']?.toString() ?? '0.00';
    final String createdAt = order['created_at']?.toString().split('T').first ?? '';
    final String? invoiceNo = order['invoice_no'];
    final List<dynamic> cartItems = order['cart'] is List ? order['cart'] : [];
    final bool isBilled = billingStatus == 'billed';

    return Card(
      margin: const EdgeInsets.only(bottom: 14),
      elevation: 0,
      shape: RoundedRectangleBorder(
        borderRadius: BorderRadius.circular(14),
        side: BorderSide(color: Colors.grey.shade200),
      ),
      color: Colors.white,
      child: Padding(
        padding: const EdgeInsets.all(16),
        child: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            // Top: Order #, Date, Status
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Order #$id',
                  style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 16),
                ),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                  decoration: BoxDecoration(
                    color: (isBilled ? Colors.green : Colors.orange).withOpacity(0.12),
                    borderRadius: BorderRadius.circular(6),
                  ),
                  child: Text(
                    isBilled ? 'BILLED' : 'NEEDS BILLING',
                    style: TextStyle(
                      color: isBilled ? const Color(0xFF2E7D32) : Colors.orange.shade800,
                      fontWeight: FontWeight.bold,
                      fontSize: 11,
                    ),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 8),

            // Store Info & Phone
            Row(
              children: [
                const Icon(Icons.storefront_outlined, size: 18, color: Color(0xFF0D47A1)),
                const SizedBox(width: 8),
                Expanded(
                  child: Text(
                    customerName,
                    style: const TextStyle(fontSize: 14, fontWeight: FontWeight.w600),
                  ),
                ),
                if (phone.isNotEmpty) ...[
                  Icon(Icons.phone_outlined, size: 16, color: Colors.grey.shade600),
                  const SizedBox(width: 4),
                  Text(
                    phone,
                    style: TextStyle(fontSize: 13, color: Colors.grey.shade700),
                  ),
                ],
              ],
            ),
            const SizedBox(height: 8),

            // Items Count & Total
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  'Date: $createdAt | ${cartItems.length} item(s)',
                  style: TextStyle(fontSize: 12, color: Colors.grey.shade600),
                ),
                Text(
                  '₹$total',
                  style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w900, color: Color(0xFF2E7D32)),
                ),
              ],
            ),

            if (invoiceNo != null && invoiceNo.isNotEmpty) ...[
              const SizedBox(height: 8),
              Container(
                width: double.infinity,
                padding: const EdgeInsets.symmetric(horizontal: 12, vertical: 6),
                decoration: BoxDecoration(
                  color: Colors.green.shade50,
                  borderRadius: BorderRadius.circular(8),
                ),
                child: Row(
                  children: [
                    const Icon(Icons.verified_outlined, color: Color(0xFF2E7D32), size: 18),
                    const SizedBox(width: 8),
                    Text(
                      'Invoice No: $invoiceNo',
                      style: const TextStyle(fontWeight: FontWeight.bold, color: Color(0xFF2E7D32), fontSize: 13),
                    ),
                  ],
                ),
              ),
            ],

            const SizedBox(height: 12),
            const Divider(height: 1),
            const SizedBox(height: 10),

            // Medicines List Preview
            const Text(
              'Medicines for Invoice:',
              style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.blueGrey),
            ),
            const SizedBox(height: 6),
            ...cartItems.map((item) => Padding(
                  padding: const EdgeInsets.symmetric(vertical: 3),
                  child: Row(
                    children: [
                      const Icon(Icons.circle, size: 6, color: Colors.grey),
                      const SizedBox(width: 8),
                      Expanded(
                        child: Text(
                          item['product_name'] ?? item['name'] ?? 'Medicine',
                          style: const TextStyle(fontSize: 13, fontWeight: FontWeight.w600),
                        ),
                      ),
                      Text(
                        '${item['quantity'] ?? 1} ${item['unit'] ?? 'Box'}',
                        style: const TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Color(0xFF0D47A1)),
                      ),
                    ],
                  ),
                )),

            const SizedBox(height: 14),

            // Action Button
            SizedBox(
              width: double.infinity,
              height: 44,
              child: ElevatedButton.icon(
                style: ElevatedButton.styleFrom(
                  backgroundColor: isBilled ? Colors.grey.shade700 : const Color(0xFF0D47A1),
                  foregroundColor: Colors.white,
                  shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(10)),
                  elevation: 0,
                ),
                icon: Icon(isBilled ? Icons.edit_note : Icons.receipt_long, size: 18),
                label: Text(
                  isBilled ? 'Update Invoice Details' : 'Generate / Complete Invoice Bill',
                  style: const TextStyle(fontSize: 14, fontWeight: FontWeight.bold),
                ),
                onPressed: () => _showInvoiceDialog(context, order, biller),
              ),
            ),
          ],
        ),
      ),
    );
  }

  void _showInvoiceDialog(BuildContext context, dynamic order, BillerProvider biller) {
    final formKey = GlobalKey<FormState>();
    final invoiceCtrl = TextEditingController(text: order['invoice_no'] ?? '');
    final notesCtrl = TextEditingController(text: order['billing_notes'] ?? '');

    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text('Billing Order #${order['id']}'),
        content: Form(
          key: formKey,
          child: Column(
            mainAxisSize: MainAxisSize.min,
            children: [
              TextFormField(
                controller: invoiceCtrl,
                decoration: const InputDecoration(
                  labelText: 'Invoice / Bill Number *',
                  hintText: 'e.g. INV-2026-0042',
                  prefixIcon: Icon(Icons.receipt),
                ),
                validator: (val) => val == null || val.trim().isEmpty ? 'Please enter invoice number' : null,
              ),
              const SizedBox(height: 12),
              TextFormField(
                controller: notesCtrl,
                maxLines: 2,
                decoration: const InputDecoration(
                  labelText: 'Billing Notes (Optional)',
                  hintText: 'e.g. Packed in 2 cartons, ready for dispatch',
                  prefixIcon: Icon(Icons.note_alt_outlined),
                ),
              ),
            ],
          ),
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Cancel')),
          ElevatedButton(
            style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFF2E7D32)),
            onPressed: () async {
              if (!formKey.currentState!.validate()) return;
              Navigator.pop(ctx);

              final success = await biller.updateBilling(
                orderId: order['id'],
                invoiceNo: invoiceCtrl.text.trim(),
                billingStatus: 'billed',
                notes: notesCtrl.text.trim(),
              );

              if (success && context.mounted) {
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(
                    content: Text('Order marked as Billed successfully! 🎉'),
                    backgroundColor: Color(0xFF2E7D32),
                    behavior: SnackBarBehavior.floating,
                  ),
                );
              }
            },
            child: const Text('Save & Mark Billed', style: TextStyle(color: Colors.white)),
          ),
        ],
      ),
    );
  }
}
