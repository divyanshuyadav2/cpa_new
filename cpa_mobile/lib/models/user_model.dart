class User {
  final int id;
  final String name;
  final String email;
  final String role;
  final String? phone;
  final String? companyName;
  final String? address;
  final int? salesmanId;

  User({
    required this.id,
    required this.name,
    required this.email,
    required this.role,
    this.phone,
    this.companyName,
    this.address,
    this.salesmanId,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'] is int ? json['id'] : (int.tryParse(json['id']?.toString() ?? '0') ?? 0),
      name: json['name']?.toString() ?? '',
      email: json['email']?.toString() ?? '',
      role: json['role']?.toString().toLowerCase() ?? 'retailer',
      phone: json['phone']?.toString(),
      companyName: json['company_name']?.toString(),
      address: json['address']?.toString(),
      salesmanId: json['salesman_id'] is int
          ? json['salesman_id']
          : int.tryParse(json['salesman_id']?.toString() ?? ''),
    );
  }

  Map<String, dynamic> toJson() {
    return {
      'id': id,
      'name': name,
      'email': email,
      'role': role,
      'phone': phone,
      'company_name': companyName,
      'address': address,
      'salesman_id': salesmanId,
    };
  }
}

