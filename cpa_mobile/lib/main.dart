import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import 'core/constants/theme.dart';
import 'core/router/app_router.dart';
import 'providers/auth_provider.dart';
import 'providers/cart_provider.dart';
import 'providers/catalog_provider.dart';
import 'providers/salesman_provider.dart';
import 'providers/admin_provider.dart';
import 'providers/biller_provider.dart';
import 'services/notification_service.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();

  // Safely initialize push notifications (handles background, tokens, permissions)
  try {
    await NotificationService.instance.initialize().timeout(const Duration(seconds: 4));
  } catch (e) {
    debugPrint('NotificationService init error: $e');
  }

  final authProvider = AuthProvider();
  final cartProvider = CartProvider();

  // Safely initialize providers with timeout so startup never hangs on a dark screen
  try {
    await authProvider.init().timeout(const Duration(seconds: 4));
  } catch (e) {
    debugPrint('AuthProvider init error: $e');
  }

  try {
    await cartProvider.init().timeout(const Duration(seconds: 4));
  } catch (e) {
    debugPrint('CartProvider init error: $e');
  }

  // Inject active AuthProvider into GoRouter for reactive route guarding
  final router = AppRouter.createRouter(authProvider);

  // Handle push notification tap navigation
  NotificationService.instance.onNotificationOpened = (message) {
    debugPrint('[FCM Navigation] Notification opened: ${message.data}');
    if (authProvider.isAdmin) {
      router.go('/admin');
    } else if (authProvider.isSalesman) {
      router.go('/salesman');
    } else if (authProvider.isRetailer) {
      router.go('/retailer');
    } else if (authProvider.isBiller) {
      router.go('/biller');
    }
  };

  runApp(
    MultiProvider(
      providers: [
        ChangeNotifierProvider.value(value: authProvider),
        ChangeNotifierProvider.value(value: cartProvider),
        ChangeNotifierProvider(create: (_) => CatalogProvider()),
        ChangeNotifierProvider(create: (_) => SalesmanProvider()),
        ChangeNotifierProvider(create: (_) => AdminProvider()),
        ChangeNotifierProvider(create: (_) => BillerProvider()),
      ],
      child: CPAMobileApp(router: router),
    ),
  );
}

class CPAMobileApp extends StatelessWidget {
  final GoRouter router;

  const CPAMobileApp({super.key, required this.router});

  @override
  Widget build(BuildContext context) {
    return MaterialApp.router(
      title: 'CPA',
      theme: AppTheme.lightTheme,
      darkTheme: AppTheme.lightTheme, // Force clean light theme even on dark mode devices
      themeMode: ThemeMode.light,
      routerConfig: router,
      debugShowCheckedModeBanner: false,
    );
  }
}
