import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import '../../providers/auth_provider.dart';
import '../../providers/admin_provider.dart';

class AdminDashboard extends StatefulWidget {
  const AdminDashboard({super.key});

  @override
  State<AdminDashboard> createState() => _AdminDashboardState();
}

class _AdminDashboardState extends State<AdminDashboard> {
  final _searchController = TextEditingController();

  @override
  void initState() {
    super.initState();
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<AdminProvider>().init();
    });
  }

  @override
  void dispose() {
    _searchController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final admin = context.watch<AdminProvider>();
    final auth = context.watch<AuthProvider>();
    final stats = admin.stats;

    return Scaffold(
      backgroundColor: const Color(0xFFF8FAFC),
      appBar: AppBar(
        leading: Padding(
          padding: const EdgeInsets.only(left: 12.0, top: 10.0, bottom: 10.0),
          child: Image.asset(
            'assets/images/cpa_logo_white.png',
            fit: BoxFit.contain,
          ),
        ),
        title: Column(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            const Text(
              'Admin Console',
              style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold),
            ),
            Text(
              auth.user?.email ?? 'Administrator',
              style: const TextStyle(fontSize: 12, fontWeight: FontWeight.normal, color: Colors.white70),
            ),
          ],
        ),
        actions: [
          IconButton(
            tooltip: 'Add Billing Operator',
            icon: const Icon(Icons.person_add_alt_1_rounded),
            onPressed: () => _showAddBillerDialog(context),
          ),
          IconButton(
            tooltip: 'Refresh',
            icon: const Icon(Icons.refresh_rounded),
            onPressed: () => admin.loadOrders(),
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
        onRefresh: () => admin.loadOrders(),
        child: CustomScrollView(
          slivers: [
            // Top Stats Summary
            SliverToBoxAdapter(
              child: Container(
                color: Colors.white,
                padding: const EdgeInsets.fromLTRB(16, 16, 16, 12),
                child: Column(
                  children: [
                    Row(
                      children: [
                        _buildStatCard('Total Orders', '${stats['total'] ?? 0}', Colors.indigo, Icons.receipt_long),
                        const SizedBox(width: 10),
                        _buildStatCard('Pending', '${stats['pending'] ?? 0}', Colors.orange, Icons.pending_actions),
                      ],
                    ),
                    const SizedBox(height: 10),
                    Row(
                      children: [
                        _buildStatCard('Approved', '${stats['approved'] ?? 0}', Colors.blue, Icons.thumb_up_alt_outlined),
                        const SizedBox(width: 10),
                        _buildStatCard('Unassigned', '${stats['unassigned_billing'] ?? 0}', Colors.redAccent, Icons.assignment_late_outlined),
                      ],
                    ),
                  ],
                ),
              ),
            ),

            // Search Bar & Filter Chips
            SliverToBoxAdapter(
              child: Container(
                color: Colors.white,
                padding: const EdgeInsets.fromLTRB(16, 0, 16, 14),
                child: Column(
                  children: [
                    // Search Bar
                    TextField(
                      controller: _searchController,
                      decoration: InputDecoration(
                        hintText: 'Search order #, store, customer, phone...',
                        hintStyle: TextStyle(fontSize: 13, color: Colors.grey.shade500),
                        prefixIcon: const Icon(Icons.search, size: 20),
                        suffixIcon: _searchController.text.isNotEmpty
                            ? IconButton(
                                icon: const Icon(Icons.clear, size: 18),
                                onPressed: () {
                                  _searchController.clear();
                                  admin.setSearchQuery('');
                                },
                              )
                            : null,
                        filled: true,
                        fillColor: const Color(0xFFF1F5F9),
                        contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
                        border: OutlineInputBorder(
                          borderRadius: BorderRadius.circular(10),
                          borderSide: BorderSide.none,
                        ),
                      ),
                      onSubmitted: (query) => admin.setSearchQuery(query),
                    ),
                    const SizedBox(height: 12),

                    // Status Filters Scroll
                    SingleChildScrollView(
                      scrollDirection: Axis.horizontal,
                      child: Row(
                        children: [
                          _buildFilterChip(context, admin, 'all', 'All Orders'),
                          _buildFilterChip(context, admin, 'pending', 'Pending'),
                          _buildFilterChip(context, admin, 'approved', 'Approved'),
                          _buildFilterChip(context, admin, 'processing', 'Processing'),
                          _buildFilterChip(context, admin, 'completed', 'Completed'),
                          _buildFilterChip(context, admin, 'cancelled', 'Cancelled'),
                        ],
                      ),
                    ),
                  ],
                ),
              ),
            ),

            // Orders List
            if (admin.isLoading)
              const SliverFillRemaining(
                child: Center(child: CircularProgressIndicator()),
              )
            else if (admin.orders.isEmpty)
              SliverFillRemaining(
                child: Center(
                  child: Column(
                    mainAxisAlignment: MainAxisAlignment.center,
                    children: [
                      Icon(Icons.inbox_outlined, size: 64, color: Colors.grey.shade400),
                      const SizedBox(height: 12),
                      Text(
                        'No orders found',
                        style: TextStyle(fontSize: 16, fontWeight: FontWeight.bold, color: Colors.grey.shade700),
                      ),
                      const SizedBox(height: 4),
                      Text(
                        'Orders will appear here as retailers place them.',
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
                      final order = admin.orders[index];
                      return _buildOrderCard(context, order, admin);
                    },
                    childCount: admin.orders.length,
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
        padding: const EdgeInsets.symmetric(horizontal: 14, vertical: 12),
        decoration: BoxDecoration(
          color: color.withOpacity(0.08),
          borderRadius: BorderRadius.circular(12),
          border: Border.all(color: color.withOpacity(0.2)),
        ),
        child: Row(
          children: [
            Container(
              padding: const EdgeInsets.all(8),
              decoration: BoxDecoration(
                color: color.withOpacity(0.15),
                borderRadius: BorderRadius.circular(8),
              ),
              child: Icon(icon, color: color, size: 20),
            ),
            const SizedBox(width: 10),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
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
          ],
        ),
      ),
    );
  }

  Widget _buildFilterChip(BuildContext context, AdminProvider admin, String value, String label) {
    final isSelected = admin.selectedStatus == value;
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
        onSelected: (_) => admin.setStatusFilter(value),
      ),
    );
  }

  Widget _buildOrderCard(BuildContext context, dynamic order, AdminProvider admin) {
    final int id = order['id'];
    final String status = order['status'] ?? 'pending';
    final String customerName = order['customer_name'] ?? 'Retailer';
    final String phone = order['phone'] ?? '';
    final String total = order['total']?.toString() ?? '0.00';
    final String createdAt = order['created_at']?.toString().split('T').first ?? '';
    final dynamic biller = order['biller'];
    final List<dynamic> cartItems = order['cart'] is List ? order['cart'] : [];

    Color statusColor;
    switch (status) {
      case 'approved':
        statusColor = Colors.blue;
        break;
      case 'processing':
        statusColor = Colors.purple;
        break;
      case 'completed':
        statusColor = const Color(0xFF2E7D32);
        break;
      case 'cancelled':
        statusColor = Colors.red;
        break;
      default:
        statusColor = Colors.orange;
    }

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
                Row(
                  children: [
                    Text(
                      'Order #$id',
                      style: const TextStyle(fontWeight: FontWeight.w900, fontSize: 16),
                    ),
                    const SizedBox(width: 8),
                    Text(
                      createdAt,
                      style: TextStyle(color: Colors.grey.shade500, fontSize: 12),
                    ),
                  ],
                ),
                Container(
                  padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                  decoration: BoxDecoration(
                    color: statusColor.withOpacity(0.12),
                    borderRadius: BorderRadius.circular(6),
                  ),
                  child: Text(
                    status.toUpperCase(),
                    style: TextStyle(color: statusColor, fontWeight: FontWeight.bold, fontSize: 11),
                  ),
                ),
              ],
            ),
            const SizedBox(height: 10),

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

            // Total & Items Count
            Row(
              mainAxisAlignment: MainAxisAlignment.spaceBetween,
              children: [
                Text(
                  '${cartItems.length} item(s) ordered',
                  style: TextStyle(fontSize: 13, color: Colors.grey.shade600),
                ),
                Text(
                  '₹$total',
                  style: const TextStyle(fontSize: 18, fontWeight: FontWeight.w900, color: Color(0xFF2E7D32)),
                ),
              ],
            ),

            const SizedBox(height: 10),
            const Divider(height: 1),
            const SizedBox(height: 10),

            // Billing Status & Assigned Biller Badge
            Row(
              children: [
                const Icon(Icons.receipt_outlined, size: 16, color: Colors.blueGrey),
                const SizedBox(width: 6),
                const Text('Billing: ', style: TextStyle(fontSize: 12, color: Colors.blueGrey)),
                if (biller != null) ...[
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                    decoration: BoxDecoration(
                      color: Colors.blue.shade50,
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: Text(
                      'Assigned to: ${biller['name']}',
                      style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.blue.shade800),
                    ),
                  ),
                ] else ...[
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                    decoration: BoxDecoration(
                      color: Colors.orange.shade50,
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: Text(
                      'Unassigned',
                      style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.orange.shade800),
                    ),
                  ),
                ],
                const Spacer(),
                if (order['invoice_no'] != null && order['invoice_no'].toString().isNotEmpty)
                  Container(
                    padding: const EdgeInsets.symmetric(horizontal: 8, vertical: 2),
                    decoration: BoxDecoration(
                      color: Colors.green.shade50,
                      borderRadius: BorderRadius.circular(4),
                    ),
                    child: Text(
                      'Inv: #${order['invoice_no']}',
                      style: TextStyle(fontSize: 12, fontWeight: FontWeight.bold, color: Colors.green.shade800),
                    ),
                  ),
              ],
            ),

            const SizedBox(height: 12),

            // Action Buttons
            Row(
              children: [
                // View Items Button
                Expanded(
                  child: OutlinedButton.icon(
                    style: OutlinedButton.styleFrom(
                      padding: const EdgeInsets.symmetric(vertical: 8),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                    ),
                    icon: const Icon(Icons.list_alt, size: 16),
                    label: const Text('View Items', style: TextStyle(fontSize: 12)),
                    onPressed: () => _showOrderItemsDialog(context, order),
                  ),
                ),
                const SizedBox(width: 8),

                // Assign Biller Button
                Expanded(
                  child: ElevatedButton.icon(
                    style: ElevatedButton.styleFrom(
                      backgroundColor: const Color(0xFF0D47A1),
                      foregroundColor: Colors.white,
                      padding: const EdgeInsets.symmetric(vertical: 8),
                      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(8)),
                      elevation: 0,
                    ),
                    icon: const Icon(Icons.assignment_ind_outlined, size: 16),
                    label: const Text('Assign Biller', style: TextStyle(fontSize: 12)),
                    onPressed: () => _showAssignBillerDialog(context, order, admin),
                  ),
                ),
                const SizedBox(width: 8),

                // Update Status Button
                PopupMenuButton<String>(
                  tooltip: 'Update Status',
                  onSelected: (newStatus) async {
                    final success = await admin.updateOrderStatus(id, newStatus);
                    if (success && context.mounted) {
                      ScaffoldMessenger.of(context).showSnackBar(
                        SnackBar(
                          content: Text('Order #$id status updated to $newStatus'),
                          backgroundColor: const Color(0xFF2E7D32),
                          behavior: SnackBarBehavior.floating,
                        ),
                      );
                    }
                  },
                  itemBuilder: (context) => [
                    const PopupMenuItem(value: 'approved', child: Text('Mark as Approved')),
                    const PopupMenuItem(value: 'processing', child: Text('Mark as Processing')),
                    const PopupMenuItem(value: 'completed', child: Text('Mark as Completed')),
                    const PopupMenuItem(value: 'cancelled', child: Text('Mark as Cancelled')),
                  ],
                  child: Container(
                    padding: const EdgeInsets.all(8),
                    decoration: BoxDecoration(
                      border: Border.all(color: Colors.grey.shade300),
                      borderRadius: BorderRadius.circular(8),
                    ),
                    child: const Icon(Icons.more_vert, size: 18, color: Colors.black87),
                  ),
                ),
              ],
            ),
          ],
        ),
      ),
    );
  }

  void _showOrderItemsDialog(BuildContext context, dynamic order) {
    final List<dynamic> cartItems = order['cart'] is List ? order['cart'] : [];

    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        title: Text('Order #${order['id']} Items'),
        content: SizedBox(
          width: double.maxFinite,
          child: cartItems.isEmpty
              ? const Text('No items listed in this order.')
              : ListView.separated(
                  shrinkWrap: true,
                  itemCount: cartItems.length,
                  separatorBuilder: (_, __) => const Divider(height: 12),
                  itemBuilder: (context, i) {
                    final item = cartItems[i];
                    return Row(
                      crossAxisAlignment: CrossAxisAlignment.start,
                      children: [
                        Expanded(
                          child: Column(
                            crossAxisAlignment: CrossAxisAlignment.start,
                            children: [
                              Text(
                                item['product_name'] ?? item['name'] ?? 'Medicine Item',
                                style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13),
                              ),
                              Text(
                                'Unit: ${item['unit'] ?? 'Box'} | Qty: ${item['quantity'] ?? 1}',
                                style: TextStyle(fontSize: 12, color: Colors.grey.shade600),
                              ),
                            ],
                          ),
                        ),
                        Text(
                          '₹${item['total_price'] ?? item['price'] ?? '0.00'}',
                          style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 13),
                        ),
                      ],
                    );
                  },
                ),
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Close')),
        ],
      ),
    );
  }

  void _showAssignBillerDialog(BuildContext context, dynamic order, AdminProvider admin) {
    int? selectedBillerId = order['biller_id'];

    showDialog(
      context: context,
      builder: (ctx) => StatefulBuilder(
        builder: (context, setDialogState) {
          return AlertDialog(
            title: Text('Assign Order #${order['id']}'),
            content: SizedBox(
              width: double.maxFinite,
              child: Column(
                mainAxisSize: MainAxisSize.min,
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  const Text(
                    'Select a Billing Operator to create the invoice for this order:',
                    style: TextStyle(fontSize: 13, color: Colors.grey),
                  ),
                  const SizedBox(height: 16),
                  if (admin.billers.isEmpty)
                    const Padding(
                      padding: EdgeInsets.symmetric(vertical: 8),
                      child: Text('No billing operators found. Please add a billing operator first.'),
                    )
                  else
                    DropdownButtonFormField<int?>(
                      value: selectedBillerId,
                      decoration: InputDecoration(
                        labelText: 'Select Biller / Employee',
                        border: OutlineInputBorder(borderRadius: BorderRadius.circular(10)),
                        contentPadding: const EdgeInsets.symmetric(horizontal: 14, vertical: 10),
                      ),
                      items: [
                        const DropdownMenuItem<int?>(
                          value: null,
                          child: Text('Unassigned (Clear Assignment)'),
                        ),
                        ...admin.billers.map((b) => DropdownMenuItem<int?>(
                              value: b['id'],
                              child: Text('${b['name']} (${b['role']})'),
                            )),
                      ],
                      onChanged: (val) {
                        setDialogState(() {
                          selectedBillerId = val;
                        });
                      },
                    ),
                ],
              ),
            ),
            actions: [
              TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Cancel')),
              ElevatedButton(
                style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFF0D47A1)),
                onPressed: () async {
                  Navigator.pop(ctx);
                  final success = await admin.assignBiller(order['id'], selectedBillerId);
                  if (success && context.mounted) {
                    ScaffoldMessenger.of(context).showSnackBar(
                      const SnackBar(
                        content: Text('Order biller assignment updated successfully!'),
                        backgroundColor: Color(0xFF2E7D32),
                        behavior: SnackBarBehavior.floating,
                      ),
                    );
                  }
                },
                child: const Text('Save Assignment', style: TextStyle(color: Colors.white)),
              ),
            ],
          );
        },
      ),
    );
  }

  void _showAddBillerDialog(BuildContext context) {
    final formKey = GlobalKey<FormState>();
    final nameCtrl = TextEditingController();
    final emailCtrl = TextEditingController();
    final phoneCtrl = TextEditingController();
    final passwordCtrl = TextEditingController();

    showDialog(
      context: context,
      builder: (ctx) => AlertDialog(
        title: const Text('Add Billing Operator'),
        content: SingleChildScrollView(
          child: Form(
            key: formKey,
            child: Column(
              mainAxisSize: MainAxisSize.min,
              children: [
                TextFormField(
                  controller: nameCtrl,
                  decoration: const InputDecoration(labelText: 'Employee Name *', prefixIcon: Icon(Icons.person)),
                  validator: (val) => val == null || val.trim().isEmpty ? 'Enter employee name' : null,
                ),
                const SizedBox(height: 10),
                TextFormField(
                  controller: emailCtrl,
                  keyboardType: TextInputType.emailAddress,
                  decoration: const InputDecoration(labelText: 'Email Address *', prefixIcon: Icon(Icons.email)),
                  validator: (val) => val == null || !val.contains('@') ? 'Enter valid email' : null,
                ),
                const SizedBox(height: 10),
                TextFormField(
                  controller: phoneCtrl,
                  keyboardType: TextInputType.phone,
                  decoration: const InputDecoration(labelText: 'Phone Number *', prefixIcon: Icon(Icons.phone)),
                  validator: (val) => val == null || val.trim().length < 10 ? 'Enter valid phone number' : null,
                ),
                const SizedBox(height: 10),
                TextFormField(
                  controller: passwordCtrl,
                  decoration: const InputDecoration(labelText: 'Password *', prefixIcon: Icon(Icons.lock)),
                  obscureText: true,
                  validator: (val) => val == null || val.length < 6 ? 'Password min 6 characters' : null,
                ),
              ],
            ),
          ),
        ),
        actions: [
          TextButton(onPressed: () => Navigator.pop(ctx), child: const Text('Cancel')),
          ElevatedButton(
            style: ElevatedButton.styleFrom(backgroundColor: const Color(0xFF0D47A1)),
            onPressed: () async {
              if (!formKey.currentState!.validate()) return;
              Navigator.pop(ctx);

              final success = await context.read<AdminProvider>().createBiller(
                    name: nameCtrl.text.trim(),
                    email: emailCtrl.text.trim(),
                    phone: phoneCtrl.text.trim(),
                    password: passwordCtrl.text,
                  );

              if (success && context.mounted) {
                ScaffoldMessenger.of(context).showSnackBar(
                  const SnackBar(
                    content: Text('Billing Operator created successfully! 🎉'),
                    backgroundColor: Color(0xFF2E7D32),
                    behavior: SnackBarBehavior.floating,
                  ),
                );
              }
            },
            child: const Text('Create Account', style: TextStyle(color: Colors.white)),
          ),
        ],
      ),
    );
  }
}
