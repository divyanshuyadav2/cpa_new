class ApiConstants {
  // Live domain API endpoint (Without /cpa/ prefix)
  static const String baseUrl = 'https://chitranshupharma.com/api';
  
  // Auth Endpoints
  static const String login = '/login';
  static const String register = '/register';
  static const String logout = '/logout';
  static const String user = '/user';
  static const String deviceToken = '/device-token';
  
  // Catalog Endpoints
  static const String companies = '/companies';
  static const String products = '/products';
  static const String frequentProducts = '/products/frequent';
  
  // Order Endpoints
  static const String retailerOrders = '/orders';
  static const String checkout = '/orders/checkout';
  
  // Salesman Endpoints
  static const String salesmanRetailers = '/salesman/retailers';
  static const String salesmanOrders = '/salesman/orders';
  static String salesmanOrderStatus(int id) => '/salesman/orders/$id/status';

  // Admin Endpoints
  static const String adminOrders = '/admin/orders';
  static String adminAssignBiller(int id) => '/admin/orders/$id/assign';
  static String adminUpdateOrderStatus(int id) => '/admin/orders/$id/status';
  static const String adminBillers = '/admin/billers';
  static const String adminCreateBiller = '/admin/billers';

  // Biller Endpoints
  static const String billerOrders = '/biller/orders';
  static String billerUpdateStatus(int id) => '/biller/orders/$id/status';
}

