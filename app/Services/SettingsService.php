<?php

namespace App\Services;

use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

class SettingsService
{
    protected const CACHE_KEY = 'plantora_settings_cache';

    /**
     * Get setting value by key (e.g., 'general.site_name' or 'site_name').
     */
    public function get(string $key, mixed $default = null): mixed
    {
        $settings = $this->all();

        if (array_key_exists($key, $settings)) {
            return $settings[$key];
        }

        // Try searching without group prefix
        foreach ($settings as $settingKey => $value) {
            if ($settingKey === $key || str_ends_with($settingKey, '.' . $key)) {
                return $value;
            }
        }

        return $default;
    }

    /**
     * Set a setting value by key and clear cache.
     */
    public function set(string $key, mixed $value, string $group = 'general', string $type = 'string'): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            [
                'group' => $group,
                'value' => $value,
                'type' => $type,
            ]
        );

        $this->clearCache();
    }

    /**
     * Get all cached settings.
     */
    public function all(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            try {
                return Setting::all()->pluck('value', 'key')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });
    }

    /**
     * Clear cached settings.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
