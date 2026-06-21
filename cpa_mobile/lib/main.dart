import 'package:flutter/material.dart';
import 'package:provider/provider.dart';

import 'core/constants/theme.dart';
import 'core/router/app_router.dart';
import 'providers/auth_provider.dart';
import 'providers/cart_provider.dart';

void main() async {
  WidgetsFlutterBinding.ensureInitialized();
  
  // Initialize AuthProvider and check if user is logged in
  final authProvider = AuthProvider();
  await authProvider.init();

  runApp(
    MultiProvider(
      providers: [
        ChangeNotifierProvider.value(value: authProvider),
        ChangeNotifierProvider(create: (_) => CartProvider()),
      ],
      child: const CPAMobileApp(),
    ),
  );
}

class CPAMobileApp extends StatelessWidget {
  const CPAMobileApp({super.key});

  @override
  Widget build(BuildContext context) {
    return MaterialApp.router(
      title: 'CPA Mobile',
      theme: AppTheme.lightTheme,
      routerConfig: AppRouter.router,
      debugShowCheckedModeBanner: false,
    );
  }
}
