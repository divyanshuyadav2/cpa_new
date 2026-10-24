import 'dart:async';
import 'package:flutter/foundation.dart';
import 'package:firebase_core/firebase_core.dart';
import 'package:firebase_messaging/firebase_messaging.dart';
import '../core/api/api_client.dart';
import '../core/constants/api_constants.dart';

@pragma('vm:entry-point')
Future<void> _firebaseMessagingBackgroundHandler(RemoteMessage message) async {
  // Ensure Firebase is initialized for background processing
  try {
    await Firebase.initializeApp();
  } catch (_) {}
  debugPrint('[FCM Background] Handling message: ${message.messageId}');
}

class NotificationService {
  NotificationService._internal();
  static final NotificationService instance = NotificationService._internal();

  bool _isInitialized = false;
  String? _fcmToken;

  String? get fcmToken => _fcmToken;

  /// Callback when a foreground notification is received
  Function(RemoteMessage message)? onForegroundMessage;

  /// Callback when user taps a notification to navigate
  Function(RemoteMessage message)? onNotificationOpened;

  /// Initialize Firebase Messaging and setup handlers safely
  Future<void> initialize() async {
    if (_isInitialized) return;

    try {
      await Firebase.initializeApp();

      // Register background handler
      FirebaseMessaging.onBackgroundMessage(_firebaseMessagingBackgroundHandler);

      // Request notification permissions (Android 13+ & iOS)
      final messaging = FirebaseMessaging.instance;
      final settings = await messaging.requestPermission(
        alert: true,
        badge: true,
        sound: true,
        provisional: false,
      );

      debugPrint('[FCM] Permission status: ${settings.authorizationStatus}');

      // Configure foreground notification presentation options
      await messaging.setForegroundNotificationPresentationOptions(
        alert: true,
        badge: true,
        sound: true,
      );

      // Listen for incoming messages while app is in foreground
      FirebaseMessaging.onMessage.listen((RemoteMessage message) {
        debugPrint('[FCM Foreground] Title: ${message.notification?.title}, Body: ${message.notification?.body}');
        if (onForegroundMessage != null) {
          onForegroundMessage!(message);
        }
      });

      // Listen for message tap when app was in background
      FirebaseMessaging.onMessageOpenedApp.listen((RemoteMessage message) {
        debugPrint('[FCM Tap] Message clicked: ${message.data}');
        if (onNotificationOpened != null) {
          onNotificationOpened!(message);
        }
      });

      // Check if app was opened directly from a terminated state notification
      final initialMessage = await messaging.getInitialMessage();
      if (initialMessage != null && onNotificationOpened != null) {
        onNotificationOpened!(initialMessage);
      }

      // Fetch initial token
      // ignore: deprecated_member_use
      _fcmToken = await messaging.getToken();
      debugPrint('[FCM] Device Token: $_fcmToken');

      // Listen to token refresh
      // ignore: deprecated_member_use
      messaging.onTokenRefresh.listen((newToken) {
        _fcmToken = newToken;
        syncTokenWithBackend();
      });

      _isInitialized = true;
    } catch (e) {
      debugPrint('[FCM] Initialization skipped or failed: $e');
      // Graceful fallback: do not crash app if google-services.json is pending
    }
  }

  /// Sync device FCM token with Laravel backend
  Future<void> syncTokenWithBackend({String? role}) async {
    try {
      if (_fcmToken == null && _isInitialized) {
        // ignore: deprecated_member_use
        _fcmToken = await FirebaseMessaging.instance.getToken();
      }

      if (_fcmToken == null || _fcmToken!.isEmpty) return;

      await ApiClient.instance.post(
        ApiConstants.deviceToken,
        data: {
          'token': _fcmToken,
          'platform': 'android',
        },
      );
      debugPrint('[FCM] Token registered with backend successfully.');

      // If user is Admin, subscribe to admin_orders topic
      if (role == 'admin') {
        await FirebaseMessaging.instance.subscribeToTopic('admin_orders');
        debugPrint('[FCM] Subscribed to topic: admin_orders');
      }
    } catch (e) {
      debugPrint('[FCM] Failed to sync token with backend: $e');
    }
  }

  /// Unregister device token and unsubscribe topics upon logout
  Future<void> removeToken({String? role}) async {
    try {
      if (role == 'admin' && _isInitialized) {
        await FirebaseMessaging.instance.unsubscribeFromTopic('admin_orders');
      }

      if (_fcmToken != null && _fcmToken!.isNotEmpty) {
        await ApiClient.instance.delete(
          ApiConstants.deviceToken,
          data: {'token': _fcmToken},
        );
      }
    } catch (e) {
      debugPrint('[FCM] Failed to remove device token: $e');
    }
  }
}
