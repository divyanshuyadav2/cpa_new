import 'package:flutter/material.dart';
import 'package:provider/provider.dart';
import 'package:intl/intl.dart';
import '../../providers/auth_provider.dart';
import '../../providers/salesman_provider.dart';
import '../../models/order_model.dart';
import '../../models/user_model.dart';

class SalesmanDashboard extends StatefulWidget {
  const SalesmanDashboard({super.key});

  @override
  State<SalesmanDashboard> createState() => _SalesmanDashboardState();
}

class _SalesmanDashboardState extends State<SalesmanDashboard> with SingleTickerProviderStateMixin {
  late TabController _tabController;
  final _searchController = TextEditingController();

  @override
  void initState() {
    super.initState();
    _tabController = TabController(length: 2, vsync: this);
    WidgetsBinding.instance.addPostFrameCallback((_) {
      context.read<SalesmanProvider>().init();
    });
  }

  @override
  void dispose() {
    _tabController.dispose();
    _searchController.dispose();
    super.dispose();
  }

  @override
  Widget build(BuildContext context) {
    final auth = context.watch<AuthProvider>();
    final salesman = context.watch<SalesmanProvider>();

    return Scaffold(
      appBar: AppBar(
        title: Column(
          children: [
            const Text('Salesman Field Portal', style: TextStyle(fontSize: 18, fontWeight: FontWeight.bold)),
            if (auth.user?.name != null)
              Text(
                'Officer: ${auth.user!.name}',
                style: const TextStyle(fontSize: 12, fontWeight: FontWeight.normal, color: Colors.white70),
              ),
          ],
        ),
        actions: [
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
                    TextButton(
                      onPressed: () => Navigator.pop(ctx, false),
                      child: const Text('Cancel'),
                    ),
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
        bottom: TabBar(
          controller: _tabController,
          indicatorColor: Colors.white,
          labelColor: Colors.white,
          unselectedLabelColor: Colors.white60,
          labelStyle: const TextStyle(fontWeight: FontWeight.bold),
          tabs: [
            Tab(
              icon: const Icon(Icons.shopping_bag_outlined),
              text: 'Orders (${salesman.totalOrdersCount})',
            ),
            Tab(
              icon: const Icon(Icons.store_outlined),
              text: 'Retailers (${salesman.retailers.length})',
            ),
          ],
        ),
      ),
      body: Column(
        children: [
          // KPI Metric Banner
          Container(
            color: Colors.white,
            padding: const EdgeInsets.symmetric(horizontal: 16, vertical: 12),
            child: Row(
              children: [
                _buildKpiCard(
                  'Total Orders',
                  '${salesman.totalOrdersCount}',
                  const Color(0xFF0D47A1),
                  Icons.receipt_outlined,
                ),
                const SizedBox(width: 8),
                _buildKpiCard(
                  'Pending',
                  '${salesman.pendingOrdersCount}',
                  Colors.orange.shade800,
                  Icons.hourglass_top_outlined,
                ),
                const SizedBox(width: 8),
                _buildKpiCard(
                  'Delivered',
                  '${salesman.deliveredOrdersCount}',
                  const Color(0xFF2E7D32),
                  Icons.check_circle_outline,
                ),
              ],
            ),
          ),
          const Divider(height: 1),

          // Tab views
          Expanded(
            child: TabBarView(
              controller: _tabController,
              children: [
                _OrdersTab(searchController: _searchController),
                const _RetailersTab(),
              ],
            ),
          ),
        ],
      ),
    );
  }

  Widget _buildKpiCard(String label, String value, Color color, IconData icon) {
    return Expanded(
      child: Container(
        padding: const EdgeInsets.symmetric(vertical: 8, horizontal: 10),
        decoration: BoxDecoration(
          color: color.withValues(alpha: 0.08),
          borderRadius: BorderRadius.circular(10),
          border: Border.all(color: color.withValues(alpha: 0.2)),
        ),
        child: Row(
          children: [
            Icon(icon, size: 24, color: color),
            const SizedBox(width: 6),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    value,
                    style: TextStyle(
                      fontSize: 18,
                      fontWeight: FontWeight.w800,
                      color: color,
                    ),
                  ),
                  Text(
                    label,
                    style: TextStyle(
                      fontSize: 10,
                      fontWeight: FontWeight.w600,
                      color: Colors.grey.shade700,
                    ),
                    maxLines: 1,
                    overflow: TextOverflow.ellipsis,
                  ),
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}

class _OrdersTab extends StatelessWidget {
  final TextEditingController searchController;

  const _OrdersTab({required this.searchController});

  @override
  Widget build(BuildContext context) {
    final salesman = context.watch<SalesmanProvider>();
    final filterChips = ['All', 'Pending', 'Confirmed', 'Dispatched', 'Delivered'];

    return Column(
      children: [
        // Search & Status Filters
        Container(
          color: Colors.white,
          padding: const EdgeInsets.fromLTRB(16, 8, 16, 10),
          child: Column(
            children: [
              TextField(
                controller: searchController,
                onChanged: (val) => salesman.setSearchQuery(val),
                decoration: InputDecoration(
                  hintText: 'Search order #, retailer, customer, phone...',
                  hintStyle: TextStyle(fontSize: 13, color: Colors.grey.shade500),
                  prefixIcon: const Icon(Icons.search, size: 20),
                  suffixIcon: searchController.text.isNotEmpty
                      ? IconButton(
                          icon: const Icon(Icons.clear, size: 18),
                          onPressed: () {
                            searchController.clear();
                            salesman.setSearchQuery('');
                          },
                        )
                      : null,
                  filled: true,
                  fillColor: const Color(0xFFF1F5F9),
                  contentPadding: const EdgeInsets.symmetric(vertical: 0, horizontal: 14),
                  border: OutlineInputBorder(
                    borderRadius: BorderRadius.circular(10),
                    borderSide: BorderSide.none,
                  ),
                ),
              ),
              const SizedBox(height: 8),
              SizedBox(
                height: 34,
                child: ListView.separated(
                  scrollDirection: Axis.horizontal,
                  itemCount: filterChips.length,
                  separatorBuilder: (_, __) => const SizedBox(width: 6),
                  itemBuilder: (context, idx) {
                    final status = filterChips[idx];
                    final isSelected = salesman.selectedStatusFilter.toLowerCase() == status.toLowerCase();
                    return ChoiceChip(
                      label: Text(status),
                      selected: isSelected,
                      onSelected: (_) => salesman.setStatusFilter(status),
                      selectedColor: const Color(0xFF0D47A1),
                      labelStyle: TextStyle(
                        fontSize: 12,
                        color: isSelected ? Colors.white : Colors.black87,
                        fontWeight: isSelected ? FontWeight.bold : FontWeight.normal,
                      ),
                      visualDensity: VisualDensity.compact,
                    );
                  },
                ),
              ),
            ],
          ),
        ),

        // Orders List
        Expanded(
          child: RefreshIndicator(
            onRefresh: () => salesman.fetchOrders(resetPage: true),
            child: salesman.isLoading && salesman.filteredOrders.isEmpty
                ? const Center(child: CircularProgressIndicator())
                : salesman.filteredOrders.isEmpty
                    ? Center(
                        child: SingleChildScrollView(
                          physics: const AlwaysScrollableScrollPhysics(),
                          padding: const EdgeInsets.all(24),
                          child: Column(
                            children: [
                              Icon(Icons.inventory_2_outlined, size: 64, color: Colors.grey.shade400),
                              const SizedBox(height: 12),
                              const Text('No orders match your criteria',
                                  style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                              const SizedBox(height: 6),
                              Text('Check back later or adjust the active filters.',
                                  style: TextStyle(color: Colors.grey.shade600, fontSize: 13)),
                            ],
                          ),
                        ),
                      )
                    : ListView.builder(
                        physics: const AlwaysScrollableScrollPhysics(),
                        padding: const EdgeInsets.all(12),
                        itemCount: salesman.filteredOrders.length,
                        itemBuilder: (context, index) {
                          final order = salesman.filteredOrders[index];
                          return _SalesmanOrderCard(order: order);
                        },
                      ),
          ),
        ),
      ],
    );
  }
}

class _SalesmanOrderCard extends StatelessWidget {
  final Order order;

  const _SalesmanOrderCard({required this.order});

  Color _getStatusColor(String status) {
    switch (status.toLowerCase()) {
      case 'confirmed':
        return Colors.blue.shade700;
      case 'dispatched':
        return Colors.purple.shade700;
      case 'delivered':
        return const Color(0xFF2E7D32);
      case 'pending':
      default:
        return Colors.orange.shade800;
    }
  }

  Color _getStatusBgColor(String status) {
    switch (status.toLowerCase()) {
      case 'confirmed':
        return Colors.blue.shade50;
      case 'dispatched':
        return Colors.purple.shade50;
      case 'delivered':
        return Colors.green.shade50;
      case 'pending':
      default:
        return Colors.orange.shade50;
    }
  }

  @override
  Widget build(BuildContext context) {
    final salesman = context.read<SalesmanProvider>();

    DateTime? date;
    try {
      date = DateTime.parse(order.createdAt);
    } catch (_) {}

    final dateStr = date != null
        ? DateFormat('dd MMM yyyy, hh:mm a').format(date.toLocal())
        : order.createdAt;

    return Card(
      margin: const EdgeInsets.only(bottom: 12),
      elevation: 1.5,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: ExpansionTile(
        shape: const Border(),
        leading: Container(
          padding: const EdgeInsets.all(8),
          decoration: BoxDecoration(
            color: _getStatusBgColor(order.status),
            borderRadius: BorderRadius.circular(8),
          ),
          child: Icon(Icons.receipt_long, color: _getStatusColor(order.status)),
        ),
        title: Row(
          mainAxisAlignment: MainAxisAlignment.spaceBetween,
          children: [
            Text('Order #${order.id}', style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
            // Status Changer Dropdown
            PopupMenuButton<String>(
              tooltip: 'Update Delivery Status',
              initialValue: order.status,
              onSelected: (newStatus) async {
                if (newStatus == order.status) return;
                final success = await salesman.updateOrderStatus(order.id, newStatus);
                if (context.mounted) {
                  ScaffoldMessenger.of(context).showSnackBar(
                    SnackBar(
                      content: Text(
                        success
                            ? 'Order #${order.id} marked as $newStatus'
                            : 'Failed to update order status',
                      ),
                      backgroundColor: success ? const Color(0xFF2E7D32) : Colors.red,
                      behavior: SnackBarBehavior.floating,
                      duration: const Duration(seconds: 2),
                    ),
                  );
                }
              },
              itemBuilder: (context) => [
                'Pending',
                'Confirmed',
                'Dispatched',
                'Delivered',
              ].map((s) => PopupMenuItem(
                    value: s,
                    child: Row(
                      children: [
                        Icon(
                          s == order.status ? Icons.check_circle : Icons.circle_outlined,
                          size: 16,
                          color: _getStatusColor(s),
                        ),
                        const SizedBox(width: 8),
                        Text(s, style: TextStyle(fontWeight: s == order.status ? FontWeight.bold : FontWeight.normal)),
                      ],
                    ),
                  )).toList(),
              child: Container(
                padding: const EdgeInsets.symmetric(horizontal: 10, vertical: 4),
                decoration: BoxDecoration(
                  color: _getStatusBgColor(order.status),
                  borderRadius: BorderRadius.circular(16),
                  border: Border.all(color: _getStatusColor(order.status).withValues(alpha: 0.3)),
                ),
                child: Row(
                  mainAxisSize: MainAxisSize.min,
                  children: [
                    Text(
                      order.status,
                      style: TextStyle(
                        fontSize: 12,
                        fontWeight: FontWeight.bold,
                        color: _getStatusColor(order.status),
                      ),
                    ),
                    const SizedBox(width: 4),
                    Icon(Icons.arrow_drop_down, size: 16, color: _getStatusColor(order.status)),
                  ],
                ),
              ),
            ),
          ],
        ),
        subtitle: Padding(
          padding: const EdgeInsets.only(top: 4.0),
          child: Column(
            crossAxisAlignment: CrossAxisAlignment.start,
            children: [
              Text(
                '${order.customerName}${order.user?.companyName != null ? ' (${order.user!.companyName})' : ''}',
                style: const TextStyle(fontWeight: FontWeight.w600, fontSize: 13, color: Colors.black87),
              ),
              Row(
                mainAxisAlignment: MainAxisAlignment.spaceBetween,
                children: [
                  Text('📞 ${order.phone}', style: TextStyle(fontSize: 12, color: Colors.grey.shade700)),
                  Text(
                    '₹${order.total.toStringAsFixed(2)}',
                    style: const TextStyle(
                      fontWeight: FontWeight.bold,
                      fontSize: 15,
                      color: Color(0xFF2E7D32),
                    ),
                  ),
                ],
              ),
              Text(dateStr, style: TextStyle(fontSize: 11, color: Colors.grey.shade500)),
            ],
          ),
        ),
        children: [
          const Divider(height: 1),
          Padding(
            padding: const EdgeInsets.all(12),
            child: Column(
              crossAxisAlignment: CrossAxisAlignment.start,
              children: [
                const Text('Items Breakdown:', style: TextStyle(fontWeight: FontWeight.bold, fontSize: 13)),
                const SizedBox(height: 6),
                if (order.cart.isEmpty)
                  const Text('No item details available.', style: TextStyle(fontSize: 12))
                else
                  ...order.cart.map((rawItem) {
                    if (rawItem is! Map) return const SizedBox();
                    final name = rawItem['name'] ?? rawItem['product_name'] ?? 'Product';
                    final qty = rawItem['qty'] ?? rawItem['quantity'] ?? 1;
                    final unit = rawItem['unit'] ?? 'Box';
                    final price = rawItem['price'] ?? 0;
                    final subtotal = rawItem['subtotal'] ?? rawItem['total'] ?? (qty * price);

                    return Padding(
                      padding: const EdgeInsets.symmetric(vertical: 3),
                      child: Row(
                        mainAxisAlignment: MainAxisAlignment.spaceBetween,
                        children: [
                          Expanded(
                            child: Text('$name ($qty $unit)', style: const TextStyle(fontSize: 13)),
                          ),
                          Text(
                            '₹${double.tryParse(subtotal.toString())?.toStringAsFixed(2) ?? subtotal}',
                            style: TextStyle(
                              fontSize: 13,
                              color: Colors.grey.shade800,
                              fontWeight: FontWeight.w500,
                            ),
                          ),
                        ],
                      ),
                    );
                  }),
              ],
            ),
          ),
        ],
      ),
    );
  }
}

class _RetailersTab extends StatelessWidget {
  const _RetailersTab();

  @override
  Widget build(BuildContext context) {
    final salesman = context.watch<SalesmanProvider>();

    return RefreshIndicator(
      onRefresh: () => salesman.fetchRetailers(),
      child: salesman.retailers.isEmpty
          ? Center(
              child: SingleChildScrollView(
                physics: const AlwaysScrollableScrollPhysics(),
                padding: const EdgeInsets.all(24),
                child: Column(
                  children: [
                    Icon(Icons.storefront_outlined, size: 64, color: Colors.grey.shade400),
                    const SizedBox(height: 12),
                    const Text('No Retailers Assigned',
                        style: TextStyle(fontWeight: FontWeight.bold, fontSize: 16)),
                    const SizedBox(height: 6),
                    Text('Retailers mapped to your salesman profile will appear here.',
                        textAlign: TextAlign.center,
                        style: TextStyle(color: Colors.grey.shade600, fontSize: 13)),
                  ],
                ),
              ),
            )
          : ListView.builder(
              physics: const AlwaysScrollableScrollPhysics(),
              padding: const EdgeInsets.all(12),
              itemCount: salesman.retailers.length,
              itemBuilder: (context, index) {
                final retailer = salesman.retailers[index];
                return _RetailerCard(retailer: retailer);
              },
            ),
    );
  }
}

class _RetailerCard extends StatelessWidget {
  final User retailer;

  const _RetailerCard({required this.retailer});

  @override
  Widget build(BuildContext context) {
    return Card(
      margin: const EdgeInsets.only(bottom: 10),
      elevation: 1,
      shape: RoundedRectangleBorder(borderRadius: BorderRadius.circular(12)),
      child: Padding(
        padding: const EdgeInsets.all(12),
        child: Row(
          crossAxisAlignment: CrossAxisAlignment.start,
          children: [
            Container(
              padding: const EdgeInsets.all(10),
              decoration: BoxDecoration(
                color: const Color(0xFF0D47A1).withValues(alpha: 0.1),
                shape: BoxShape.circle,
              ),
              child: const Icon(Icons.store, color: Color(0xFF0D47A1), size: 24),
            ),
            const SizedBox(width: 12),
            Expanded(
              child: Column(
                crossAxisAlignment: CrossAxisAlignment.start,
                children: [
                  Text(
                    retailer.companyName?.isNotEmpty == true
                        ? retailer.companyName!
                        : retailer.name,
                    style: const TextStyle(fontWeight: FontWeight.bold, fontSize: 15),
                  ),
                  if (retailer.companyName?.isNotEmpty == true) ...[
                    const SizedBox(height: 2),
                    Text('Contact: ${retailer.name}',
                        style: TextStyle(fontSize: 12, color: Colors.grey.shade700)),
                  ],
                  if (retailer.phone != null && retailer.phone!.isNotEmpty) ...[
                    const SizedBox(height: 4),
                    Text('📞 ${retailer.phone}',
                        style: TextStyle(fontSize: 13, color: Colors.blue.shade900, fontWeight: FontWeight.w500)),
                  ],
                  if (retailer.address != null && retailer.address!.isNotEmpty) ...[
                    const SizedBox(height: 4),
                    Text('📍 ${retailer.address}',
                        style: TextStyle(fontSize: 12, color: Colors.grey.shade600)),
                  ],
                ],
              ),
            ),
          ],
        ),
      ),
    );
  }
}
