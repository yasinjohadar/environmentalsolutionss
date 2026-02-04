<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = [
        'site_name',
        'logo',
        'logo_dark',
        'favicon',
        'footer_background',
        'footer_description',
        'facebook_url',
        'twitter_url',
        'instagram_url',
        'linkedin_url',
        'youtube_url',
        'whatsapp_number',
        'pinterest_url',
        'tiktok_url',
        'snapchat_url',
        'telegram_url',
        'phone',
        'phone_2',
        'email',
        'email_2',
        'address',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
    ];

    protected static string $cacheKey = 'site_settings';

    /**
     * Get the site settings (singleton - single row)
     */
    public static function getSettings(): self
    {
        return Cache::rememberForever(static::$cacheKey, function () {
            $settings = static::first();
            if (!$settings) {
                $settings = static::create(['site_name' => 'حلول بيئية']);
            }
            return $settings;
        });
    }

    /**
     * Clear settings cache (call after update)
     */
    public static function clearCache(): void
    {
        Cache::forget(static::$cacheKey);
    }

    /**
     * Get logo URL
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->logo, 'frontend/assets/img/logo.svg');
    }

    /**
     * Get dark logo URL
     */
    public function getLogoDarkUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->logo_dark, $this->logo_url);
    }

    /**
     * Get favicon URL
     */
    public function getFaviconUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->favicon, 'frontend/assets/img/favicons/favicon.png');
    }

    /**
     * Get footer background URL
     */
    public function getFooterBackgroundUrlAttribute(): ?string
    {
        return $this->resolveAssetUrl($this->footer_background, 'frontend/assets/img/HomeCone/footer-bg.png');
    }

    /**
     * Resolve URL for image path
     */
    protected function resolveAssetUrl(?string $path, ?string $default = null): ?string
    {
        if (empty($path)) {
            return $default ? asset($default) : null;
        }
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'frontend/uploads/') || str_starts_with($path, 'frontend/assets/')) {
            return asset($path);
        }
        if (str_starts_with($path, 'http')) {
            return $path;
        }
        return route('storage.image.serve', ['path' => $path]);
    }

    /**
     * Get meta value by key
     */
    public function getMeta(string $key, mixed $default = null): mixed
    {
        return data_get($this->meta ?? [], $key, $default);
    }

    /**
     * Get social links as array for iteration
     */
    public function getSocialLinksAttribute(): array
    {
        $links = [];
        $platforms = [
            'facebook' => ['url' => $this->facebook_url, 'icon' => 'fab fa-facebook-f'],
            'twitter' => ['url' => $this->twitter_url, 'icon' => 'fab fa-twitter'],
            'instagram' => ['url' => $this->instagram_url, 'icon' => 'fab fa-instagram'],
            'linkedin' => ['url' => $this->linkedin_url, 'icon' => 'fab fa-linkedin-in'],
            'youtube' => ['url' => $this->youtube_url, 'icon' => 'fab fa-youtube'],
            'whatsapp' => ['url' => $this->whatsapp_number ? 'https://wa.me/' . preg_replace('/[^0-9]/', '', $this->whatsapp_number) : null, 'icon' => 'fab fa-whatsapp'],
            'pinterest' => ['url' => $this->pinterest_url, 'icon' => 'fab fa-pinterest'],
            'tiktok' => ['url' => $this->tiktok_url, 'icon' => 'fab fa-tiktok'],
            'snapchat' => ['url' => $this->snapchat_url, 'icon' => 'fab fa-snapchat-ghost'],
            'telegram' => ['url' => $this->telegram_url, 'icon' => 'fab fa-telegram-plane'],
        ];
        foreach ($platforms as $name => $data) {
            if (!empty($data['url'])) {
                $links[$name] = $data;
            }
        }
        return $links;
    }
}
