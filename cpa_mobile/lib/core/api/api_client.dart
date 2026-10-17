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
        client.connectionFactory = (uri, proxyHost, proxyPort) async {
          InternetAddress targetAddress;
          try {
            final ipv4Addresses = await InternetAddress.lookup(
              uri.host,
              type: InternetAddressType.IPv4,
            );
            targetAddress = ipv4Addresses.isNotEmpty
                ? ipv4Addresses.first
                : (await InternetAddress.lookup(uri.host)).first;
          } catch (_) {
            targetAddress = (await InternetAddress.lookup(uri.host)).first;
          }

          if (uri.scheme == 'https') {
            return SecureSocket.startConnect(
              targetAddress,
              uri.port,
              context: SecurityContext.defaultContext,
              onBadCertificate: (cert) => true,
              supportedProtocols: ['http/1.1'],
            );
          } else {
            return Socket.startConnect(targetAddress, uri.port);
          }
        };
        return client;
      },
    );

    dio.interceptors.add(AuthInterceptor());
    return dio;
  }

  static Dio get instance => _dio;
}

