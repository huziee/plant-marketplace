<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingsService;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index(SettingsService $settingsService)
    {
        $settings = $settingsService->all();
        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request, SettingsService $settingsService)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
            'whatsapp' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'pinterest_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'seo_title' => 'required|string|max:255',
            'seo_description' => 'required|string|max:500',
            'primary_color' => 'nullable|string|max:30',
            'secondary_color' => 'nullable|string|max:30',
            'accent_color' => 'nullable|string|max:30',
            'currency' => 'nullable|string|max:10',
            'timezone' => 'nullable|string|max:50',
        ]);

        $groupMapping = [
            'site_name' => 'general',
            'tagline' => 'general',
            'currency' => 'general',
            'timezone' => 'general',
            'contact_email' => 'contact',
            'contact_phone' => 'contact',
            'whatsapp' => 'contact',
            'address' => 'contact',
            'facebook_url' => 'social',
            'instagram_url' => 'social',
            'youtube_url' => 'social',
            'pinterest_url' => 'social',
            'tiktok_url' => 'social',
            'twitter_url' => 'social',
            'seo_title' => 'seo',
            'seo_description' => 'seo',
            'primary_color' => 'appearance',
            'secondary_color' => 'appearance',
            'accent_color' => 'appearance',
        ];

        foreach ($validated as $key => $value) {
            $group = $groupMapping[$key] ?? 'general';
            $settingsService->set($key, $value, $group);
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
