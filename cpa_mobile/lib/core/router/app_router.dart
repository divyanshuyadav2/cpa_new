import 'package:flutter/material.dart';
import 'package:go_router/go_router.dart';
import 'package:provider/provider.dart';

import '../../providers/auth_provider.dart';
import '../../screens/auth/login_screen.dart';
import '../../screens/admin/admin_dashboard.dart';
import '../../screens/salesman/salesman_dashboard.dart';
import '../../screens/retailer/retailer_dashboard.dart';

class AppRouter {
  static final router = GoRouter(
    initialLocation: '/login',
    redirect: (context, state) {
      final authProvider = context.read<AuthProvider>();
      final isLoggingIn = state.matchedLocation == '/login';
      
      // If not authenticated and not currently logging in, redirect to login
      if (!authProvider.isAuthenticated && !isLoggingIn) {
        return '/login';
      }

      // If authenticated and trying to access login page, redirect based on role
      if (authProvider.isAuthenticated && isLoggingIn) {
        if (authProvider.isAdmin) return '/admin';
        if (authProvider.isSalesman) return '/salesman';
        if (authProvider.isRetailer) return '/retailer';
        return '/login'; // Fallback
      }

      return null;
    },
    refreshListenable: AuthProvider(), // Re-evaluate redirects when auth state changes
    routes: [
      GoRoute(
        path: '/login',
        builder: (context, state) => const LoginScreen(),
      ),
      GoRoute(
        path: '/admin',
        builder: (context, state) => const AdminDashboard(),
      ),
      GoRoute(
        path: '/salesman',
        builder: (context, state) => const SalesmanDashboard(),
      ),
      GoRoute(
        path: '/retailer',
        builder: (context, state) => const RetailerDashboard(),
      ),
    ],
  );
}
