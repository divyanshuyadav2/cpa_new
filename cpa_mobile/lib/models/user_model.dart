class User {
  final int id;
  final String name;
  final String email;
  final String role;
  final String? phone;
  final String? companyName;
  final String? address;

  User({
    required this.id,
    required this.name,
    required this.email,
    required this.role,
    this.phone,
    this.companyName,
    this.address,
  });

  factory User.fromJson(Map<String, dynamic> json) {
    return User(
      id: json['id'],
      name: json['name'],
      email: json['email'],
      role: json['role'] ?? 'user', // Defaults to user if not provided
      phone: json['phone'],
      companyName: json['company_name'],
      address: json['address'],
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
    };
  }
}
