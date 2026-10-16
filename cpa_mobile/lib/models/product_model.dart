import 'company_model.dart';

class Product {
  final int id;
  final String name;
  final String composition;
  final String packing;
  final double mrp;
  final double ptr;
  final double pts;
  final int stockQty;
  final String? imageFullUrl;
  final Company? company;

  Product({
    required this.id,
    required this.name,
    required this.composition,
    required this.packing,
    required this.mrp,
    required this.ptr,
    required this.pts,
    required this.stockQty,
    this.imageFullUrl,
    this.company,
  });

  factory Product.fromJson(Map<String, dynamic> json) {
    return Product(
      id: json['id'] is int ? json['id'] : (int.tryParse(json['id']?.toString() ?? '0') ?? 0),
      name: json['name']?.toString() ?? '',
      composition: json['composition']?.toString() ?? '',
      packing: json['packing']?.toString() ?? '',
      mrp: double.tryParse(json['mrp']?.toString() ?? '0') ?? 0.0,
      ptr: double.tryParse(json['ptr']?.toString() ?? '0') ?? 0.0,
      pts: double.tryParse(json['pts']?.toString() ?? '0') ?? 0.0,
      stockQty: json['stock_qty'] is int ? json['stock_qty'] : (int.tryParse(json['stock_qty']?.toString() ?? '0') ?? 0),
      imageFullUrl: json['image_full_url']?.toString(),
      company: json['company'] != null && json['company'] is Map<String, dynamic>
          ? Company.fromJson(json['company'])
          : null,
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'composition': composition,
      'packing': packing,
      'mrp': mrp,
      'ptr': ptr,
      'pts': pts,
      'stock_qty': stockQty,
      'image_full_url': imageFullUrl,
      'company': company?.toJson(),
    };
  }
}

