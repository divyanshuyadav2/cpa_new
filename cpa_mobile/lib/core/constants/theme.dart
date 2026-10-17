import 'package:flutter/material.dart';

class AppTheme {
  static const Color primaryColor = Color(0xFF0D47A1); // Deep Blue
  static const Color accentColor = Color(0xFF1976D2);
  static const Color backgroundColor = Color(0xFFF8FAFC); // Clean crisp light background

  static ThemeData get lightTheme {
    return ThemeData(
      useMaterial3: true,
      brightness: Brightness.light,
      primaryColor: primaryColor,
      scaffoldBackgroundColor: backgroundColor,
      cardColor: Colors.white,
      canvasColor: Colors.white,
      colorScheme: ColorScheme.fromSeed(
        seedColor: primaryColor,
        primary: primaryColor,
        secondary: accentColor,
        surface: Colors.white,
        onSurface: const Color(0xFF1E293B),
        brightness: Brightness.light,
      ),
      appBarTheme: const AppBarTheme(
        backgroundColor: primaryColor,
        foregroundColor: Colors.white,
        elevation: 0,
        centerTitle: true,
      ),
      cardTheme: const CardThemeData(
        color: Colors.white,
        surfaceTintColor: Colors.transparent,
        elevation: 1,
      ),

      elevatedButtonTheme: ElevatedButtonThemeData(
        style: ElevatedButton.styleFrom(
          backgroundColor: primaryColor,
          foregroundColor: Colors.white,
          minimumSize: const Size(double.infinity, 50),
          shape: RoundedRectangleBorder(
            borderRadius: BorderRadius.circular(8),
          ),
        ),
      ),
      inputDecorationTheme: InputDecorationTheme(
        border: OutlineInputBorder(
          borderRadius: BorderRadius.circular(8),
        ),
        filled: true,
        fillColor: Colors.white,
      ),
    );
  }
}
