import 'dart:io';
import 'package:dio/dio.dart';
import 'package:dio/io.dart';
import '../constants/api_constants.dart';
import 'auth_interceptor.dart';

class ApiClient {
  static final Dio _dio = _createDio();

  static Dio _createDio() {
    final dio = Dio(BaseOptions(
      baseUrl: ApiConstants.baseUrl,
      connectTimeout: const Duration(seconds: 20),
      receiveTimeout: const Duration(seconds: 20),
      sendTimeout: const Duration(seconds: 20),
      headers: {
        'Accept': 'application/json',
        'Content-Type': 'application/json',
      },
    ));

    dio.httpClientAdapter = IOHttpClientAdapter(
      createHttpClient: () {
        final client = HttpClient();
        client.badCertificateCallback = (cert, host, port) => true;
        client.connectionTimeout = const Duration(seconds: 20);
        return client;
      },
    );

    dio.interceptors.add(AuthInterceptor());
    return dio;
  }

  static Dio get instance => _dio;
}

