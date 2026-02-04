<?php

use App\Models\SiteSetting;

if (!function_exists('site_setting')) {
    /**
     * Get a site setting value by key, or the full settings object.
     *
     * @param string|null $key
     * @param mixed $default
     * @return mixed
     */
    function site_setting(?string $key = null, mixed $default = null): mixed
    {
        $settings = SiteSetting::getSettings();

        if ($key === null) {
            return $settings;
        }

        return $settings->{$key} ?? $settings->getMeta($key, $default);
    }
}
