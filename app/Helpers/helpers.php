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
