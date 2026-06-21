class Company {
  final int id;
  final String name;
  final String? logoUrl;

  Company({
    required this.id,
    required this.name,
    this.logoUrl,
  });

  factory Company.fromJson(Map<String, dynamic> json) {
    return Company(
      id: json['id'],
      name: json['name'],
      logoUrl: json['logo_url'],
    );
  }
}
