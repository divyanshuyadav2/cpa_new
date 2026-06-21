class ApiConstants {
  // Use 10.0.2.2 for Android Emulator connecting to local host
  // Use your live domain when in production
  static const String baseUrl = 'https://chitranshupharma.com/cpa/api';
  
  // Auth Endpoints
  static const String login = '/login';
  static const String logout = '/logout';
  static const String user = '/user';
  
  // Catalog Endpoints
  static const String companies = '/companies';
  static const String products = '/products';
  
  // Order Endpoints
  static const String retailerOrders = '/orders';
  static const String checkout = '/orders/checkout';
  
  // Salesman Endpoints
  static const String salesmanRetailers = '/salesman/retailers';
  static const String salesmanOrders = '/salesman/orders';
}
