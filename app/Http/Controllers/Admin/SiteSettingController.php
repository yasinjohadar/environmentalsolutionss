<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class SiteSettingController extends Controller
{
    protected string $uploadPath = 'frontend/uploads/site-settings';

    /**
     * Show the form for editing site settings.
     */
    public function edit()
    {
        $settings = SiteSetting::getSettings();
        return view('admin.settings.site.edit', compact('settings'));
    }

    /**
     * Update site settings.
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'site_name' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'logo_dark' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:2048',
            'favicon' => 'nullable|file|mimes:jpeg,png,jpg,gif,ico,svg|max:512',
            'footer_background' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:3072',
            'footer_description' => 'nullable|string|max:500',
            'facebook_url' => 'nullable|url|max:255',
            'twitter_url' => 'nullable|url|max:255',
            'instagram_url' => 'nullable|url|max:255',
            'linkedin_url' => 'nullable|url|max:255',
            'youtube_url' => 'nullable|url|max:255',
            'whatsapp_number' => 'nullable|string|max:30',
            'pinterest_url' => 'nullable|url|max:255',
            'tiktok_url' => 'nullable|url|max:255',
            'snapchat_url' => 'nullable|url|max:255',
            'telegram_url' => 'nullable|url|max:255',
            'phone' => 'nullable|string|max:30',
            'phone_2' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:255',
            'email_2' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:500',
            'map_embed_src' => 'nullable|string|max:1000',
            'meta' => 'nullable|string', // JSON string
        ]);

        $settings = SiteSetting::getSettings();

        $data = collect($validated)->except(['logo', 'logo_dark', 'favicon', 'footer_background', 'meta', 'map_embed_src'])->toArray();

        if ($request->boolean('clear_logo') && $settings->logo) {
            $this->deleteImage($settings->logo);
            $data['logo'] = null;
        } elseif ($request->hasFile('logo')) {
            $this->deleteImage($settings->logo);
            $data['logo'] = $this->uploadImage($request->file('logo'), 'logo');
        }
        if ($request->boolean('clear_logo_dark') && $settings->logo_dark) {
            $this->deleteImage($settings->logo_dark);
            $data['logo_dark'] = null;
        } elseif ($request->hasFile('logo_dark')) {
            $this->deleteImage($settings->logo_dark);
            $data['logo_dark'] = $this->uploadImage($request->file('logo_dark'), 'logo_dark');
        }
        if ($request->boolean('clear_favicon') && $settings->favicon) {
            $this->deleteImage($settings->favicon);
            $data['favicon'] = null;
        } elseif ($request->hasFile('favicon')) {
            $this->deleteImage($settings->favicon);
            $data['favicon'] = $this->uploadImage($request->file('favicon'), 'favicon');
        }
        if ($request->hasFile('footer_background')) {
            $this->deleteImage($settings->footer_background);
            $data['footer_background'] = $this->uploadImage($request->file('footer_background'), 'footer_bg');
        }

        $meta = is_array($settings->meta) ? $settings->meta : [];
        if (array_key_exists('meta', $validated) && trim($validated['meta'] ?? '') !== '') {
            $decoded = json_decode(trim($validated['meta']), true);
            if (is_array($decoded)) {
                $meta = $decoded;
            }
        }
        $meta['map_embed_src'] = $request->input('map_embed_src');
        $data['meta'] = $meta;

        $settings->update($data);
        SiteSetting::clearCache();

        return redirect()->route('admin.settings.site.edit')
            ->with('success', 'تم حفظ الإعدادات بنجاح');
    }

    protected function uploadImage($file, string $prefix): string
    {
        $dir = public_path($this->uploadPath);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $ext = $file->getClientOriginalExtension() ?: 'png';
        $imageName = $prefix . '_' . time() . '.' . $ext;
        $file->move($dir, $imageName);
        return $this->uploadPath . '/' . $imageName;
    }

    protected function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }
        $path = ltrim($path, '/');
        if (str_starts_with($path, 'frontend/uploads/')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        }
    }
}
