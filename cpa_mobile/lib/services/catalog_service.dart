import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';
import '../models/company_model.dart';
import '../models/product_model.dart';

class PaginatedProducts {
  final List<Product> products;
  final int currentPage;
  final int lastPage;
  final int total;

  PaginatedProducts({
    required this.products,
    required this.currentPage,
    required this.lastPage,
    required this.total,
  });
}

class CatalogService {
  Future<List<Company>> getCompanies() async {
    try {
      final response = await ApiClient.instance.get(ApiConstants.companies);
      if (response.data is List) {
        return (response.data as List)
            .map((item) => Company.fromJson(item as Map<String, dynamic>))
            .toList();
      }
      return [];
    } catch (e) {
      return [];
    }
  }

  Future<PaginatedProducts> getProducts({
    String? search,
    int? companyId,
    int page = 1,
  }) async {
    try {
      final queryParams = <String, dynamic>{
        'page': page,
      };
      if (search != null && search.trim().isNotEmpty) {
        queryParams['search'] = search.trim();
      }
      if (companyId != null && companyId > 0) {
        queryParams['company_id'] = companyId;
      }

      final response = await ApiClient.instance.get(
        ApiConstants.products,
        queryParameters: queryParams,
      );

      final data = response.data;
      if (data is Map<String, dynamic>) {
        final List<dynamic> list = data['data'] ?? [];
        final products = list
            .map((item) => Product.fromJson(item as Map<String, dynamic>))
            .toList();
        return PaginatedProducts(
          products: products,
          currentPage: data['current_page'] is int ? data['current_page'] : 1,
          lastPage: data['last_page'] is int ? data['last_page'] : 1,
          total: data['total'] is int ? data['total'] : products.length,
        );
      }
      return PaginatedProducts(products: [], currentPage: 1, lastPage: 1, total: 0);
    } catch (e) {
      return PaginatedProducts(products: [], currentPage: 1, lastPage: 1, total: 0);
    }
  }
}
