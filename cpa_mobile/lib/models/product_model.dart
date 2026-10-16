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

  /// Parse packing string (e.g., "1*10*10", "10x10", "10*10", "20x10", "1x10")
  /// to determine how many strips are in 1 box.
  int get stripsPerBox {
    if (packing.trim().isEmpty) return 1;

    final numbers = RegExp(r'\d+')
        .allMatches(packing)
        .map((m) => int.tryParse(m.group(0) ?? '') ?? 0)
        .where((n) => n > 0)
        .toList();

    if (numbers.isEmpty) return 1;

    // Standard Indian pharma packing e.g. "1*10*10" (1 outer, 10 strips/box, 10 tabs/strip)
    if (numbers.length >= 3 && numbers[0] == 1) {
      return numbers[1] > 0 ? numbers[1] : 10;
    }
    // "10*10" or "10x10" -> 10 strips per box
    if (numbers.length >= 2) {
      return numbers[0] > 0 ? numbers[0] : 10;
    }
    // "10's" or "10 Tab"
    if (numbers.length == 1 && numbers[0] > 1) {
      return numbers[0];
    }

    return 10;
  }

  /// Price per single strip
  double get stripPrice => ptr;

  /// Price per full box (PTR * stripsPerBox)
  double get boxPrice => ptr * stripsPerBox;

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

