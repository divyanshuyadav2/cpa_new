<?php

if (!function_exists('setting')) {
    /**
     * Retrieve a setting value from the database or return default.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function setting(string $key, $default = null)
    {
        return \App\Models\Setting::get($key, $default);
    }
}

if (!function_exists('media_url')) {
    /**
     * Resolve a media path to a full URL.
     * - If the value is already an external URL (http/https), return it as-is.
     * - Otherwise treat it as a path stored on the public disk and return its URL.
     *
     * @param string|null $path
     * @return string|null
     */
    function media_url(?string $path): ?string
    {
        if (!$path) return null;

        // Already an external URL → use directly
        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        // Stored file → use Storage disk URL (respects APP_URL + symlink)
        return \Illuminate\Support\Facades\Storage::disk('public')->url($path);
    }
}
