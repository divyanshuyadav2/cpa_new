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
     * - Otherwise use asset() which respects ASSET_URL env variable automatically.
     *   Local:  asset('storage/companies/x.jpg') → http://127.0.0.1:8000/storage/companies/x.jpg
     *   Server: asset('storage/companies/x.jpg') → https://chitranshupharma.com/cpa/public/storage/companies/x.jpg
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

        return url('images/' . ltrim($path, '/'));
    }
}
