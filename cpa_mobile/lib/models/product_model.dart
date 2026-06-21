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
      id: json['id'],
      name: json['name'],
      composition: json['composition'],
      packing: json['packing'],
      mrp: double.parse(json['mrp'].toString()),
      ptr: double.parse(json['ptr'].toString()),
      pts: double.parse(json['pts'].toString()),
      stockQty: json['stock_qty'],
      imageFullUrl: json['image_full_url'],
      company: json['company'] != null ? Company.fromJson(json['company']) : null,
    );
  }
}
