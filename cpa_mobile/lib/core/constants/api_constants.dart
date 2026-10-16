class ApiConstants {
  // Live domain API endpoint (Without /cpa/ prefix)
  static const String baseUrl = 'https://chitranshupharma.com/api';
  
  // Auth Endpoints
  static const String login = '/login';
  static const String logout = '/logout';
  static const String user = '/user';
  
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
}

