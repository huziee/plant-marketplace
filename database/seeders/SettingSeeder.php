<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            // General
            ['group' => 'general', 'key' => 'site_name', 'value' => 'Plantaric', 'type' => 'string'],
            ['group' => 'general', 'key' => 'tagline', 'value' => 'Agriculture, Plants & Garden Care', 'type' => 'string'],
            ['group' => 'general', 'key' => 'currency', 'value' => 'PKR', 'type' => 'string'],
            ['group' => 'general', 'key' => 'timezone', 'value' => 'Asia/Karachi', 'type' => 'string'],

            // Contact
            ['group' => 'contact', 'key' => 'contact_email', 'value' => 'hello@plantaric.com', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'contact_phone', 'value' => '+92 300 1234567', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'whatsapp', 'value' => '+92 300 1234567', 'type' => 'string'],
            ['group' => 'contact', 'key' => 'address', 'value' => 'Gulberg III, Lahore, Pakistan', 'type' => 'string'],

            // Social
            ['group' => 'social', 'key' => 'facebook_url', 'value' => 'https://facebook.com', 'type' => 'string'],
            ['group' => 'social', 'key' => 'instagram_url', 'value' => 'https://instagram.com', 'type' => 'string'],
            ['group' => 'social', 'key' => 'youtube_url', 'value' => 'https://youtube.com', 'type' => 'string'],
            ['group' => 'social', 'key' => 'pinterest_url', 'value' => 'https://pinterest.com', 'type' => 'string'],

            // SEO Defaults
            ['group' => 'seo', 'key' => 'seo_title', 'value' => 'Plantaric — Agriculture, Plants & Botanical Care', 'type' => 'string'],
            ['group' => 'seo', 'key' => 'seo_description', 'value' => 'Discover agricultural plants, nearby nurseries, seeds, gardening supplies, plant care guides and expert botanical advice.', 'type' => 'text'],

            // Appearance
            ['group' => 'appearance', 'key' => 'primary_color', 'value' => '#123522', 'type' => 'string'],
            ['group' => 'appearance', 'key' => 'secondary_color', 'value' => '#0C2519', 'type' => 'string'],
            ['group' => 'appearance', 'key' => 'accent_color', 'value' => '#D7EF69', 'type' => 'string'],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}
