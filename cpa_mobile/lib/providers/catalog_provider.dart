import 'package:flutter/material.dart';
import '../models/company_model.dart';
import '../models/product_model.dart';
import '../services/catalog_service.dart';

class CatalogProvider with ChangeNotifier {
  final CatalogService _catalogService;

  List<Product> _products = [];
  List<Company> _companies = [];
  bool _isLoading = false;
  bool _isLoadingMore = false;
  String? _errorMessage;

  String _searchQuery = '';
  int? _selectedCompanyId;
  int _currentPage = 1;
  int _lastPage = 1;

  CatalogProvider({CatalogService? catalogService})
      : _catalogService = catalogService ?? CatalogService();

  List<Product> get products => _products;
  List<Company> get companies => _companies;
  bool get isLoading => _isLoading;
  bool get isLoadingMore => _isLoadingMore;
  String? get errorMessage => _errorMessage;
  String get searchQuery => _searchQuery;
  int? get selectedCompanyId => _selectedCompanyId;
  bool get hasMore => _currentPage < _lastPage;

  Future<void> init() async {
    await fetchCompanies();
    await fetchProducts(resetPage: true);
  }

  Future<void> fetchCompanies() async {
    try {
      _companies = await _catalogService.getCompanies();
      notifyListeners();
    } catch (_) {}
  }

  Future<void> fetchProducts({bool resetPage = false}) async {
    if (resetPage) {
      _currentPage = 1;
      _isLoading = true;
      _errorMessage = null;
      notifyListeners();
    } else {
      if (_isLoadingMore || !hasMore) return;
      _isLoadingMore = true;
      notifyListeners();
    }

    try {
      final result = await _catalogService.getProducts(
        search: _searchQuery,
        companyId: _selectedCompanyId,
        page: _currentPage,
      );

      if (resetPage) {
        _products = result.products;
      } else {
        _products.addAll(result.products);
      }

      _currentPage = result.currentPage;
      _lastPage = result.lastPage;
    } catch (_) {
      _errorMessage = 'Failed to load products. Please pull down to refresh.';
    } finally {
      _isLoading = false;
      _isLoadingMore = false;
      notifyListeners();
    }
  }

  void loadNextPage() {
    if (hasMore && !_isLoading && !_isLoadingMore) {
      _currentPage++;
      fetchProducts(resetPage: false);
    }
  }

  void setSearchQuery(String query) {
    if (_searchQuery == query) return;
    _searchQuery = query;
    fetchProducts(resetPage: true);
  }

  void selectCompany(int? companyId) {
    if (_selectedCompanyId == companyId) return;
    _selectedCompanyId = companyId;
    fetchProducts(resetPage: true);
  }

  void clearFilters() {
    _searchQuery = '';
    _selectedCompanyId = null;
    fetchProducts(resetPage: true);
  }
}

