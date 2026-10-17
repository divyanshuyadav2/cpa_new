# Flutter Core and Plugins
-keep class io.flutter.app.** { *; }
-keep class io.flutter.plugin.**  { *; }
-keep class io.flutter.util.**  { *; }
-keep class io.flutter.view.**  { *; }
-keep class io.flutter.** { *; }
-keep class io.flutter.plugins.** { *; }

# Generated Pigeon interfaces & Registrars
-keep class dev.flutter.pigeon.** { *; }
-keep class io.flutter.plugins.sharedpreferences.** { *; }
-keep class * implements io.flutter.plugin.common.PluginRegistry$Registrar { *; }
-keep class * implements io.flutter.embedding.engine.plugins.FlutterPlugin { *; }

# Kotlin Coroutines and Reflection
-keep class kotlin.coroutines.** { *; }
-keep class kotlinx.coroutines.** { *; }
-keepattributes *Annotation*,Signature,InnerClasses,EnclosingMethod

-dontwarn io.flutter.**
-dontwarn dev.flutter.pigeon.**
-dontwarn kotlin.**
-dontwarn kotlinx.**
