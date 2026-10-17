import 'package:go_router/go_router.dart';
import '../../providers/auth_provider.dart';
import '../../screens/auth/login_screen.dart';
import '../../screens/admin/admin_dashboard.dart';
import '../../screens/salesman/salesman_dashboard.dart';
import '../../screens/retailer/retailer_dashboard.dart';
import '../../screens/biller/biller_dashboard.dart';

class AppRouter {
  static GoRouter createRouter(AuthProvider authProvider) {
    return GoRouter(
      initialLocation: '/login',
      refreshListenable: authProvider,
      redirect: (context, state) {
        final isLoggingIn = state.matchedLocation == '/login';

        // If not authenticated and trying to access private route, redirect to login
        if (!authProvider.isAuthenticated && !isLoggingIn) {
          return '/login';
        }

        // If authenticated and trying to access login page, redirect based on role
        if (authProvider.isAuthenticated && isLoggingIn) {
          if (authProvider.isAdmin) return '/admin';
          if (authProvider.isSalesman) return '/salesman';
          if (authProvider.isRetailer) return '/retailer';
          if (authProvider.isBiller) return '/biller';
          return '/retailer';
        }

        return null;
      },
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
        GoRoute(
          path: '/biller',
          builder: (context, state) => const BillerDashboard(),
        ),
      ],
    );
  }
}
