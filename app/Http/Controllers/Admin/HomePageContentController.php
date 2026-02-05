<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HomePageSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class HomePageContentController extends Controller
{
    protected string $uploadPath = 'frontend/uploads/home';

    /** Dot-notation keys for file inputs (e.g. 'content.banner_fallback.image') */
    protected array $fileKeys = [
        'content.banner_fallback.image',
        'content.banner_fallback.arrow_icon',
        'content.banner_fallback.cross_shape',
        'content.sidemenu_gallery.0',
        'content.sidemenu_gallery.1',
        'content.sidemenu_gallery.2',
        'content.sidemenu_gallery.3',
        'content.services.arrow_icon',
        'content.choose_us.image1',
        'content.choose_us.image2',
        'content.choose_us.video_image',
        'content.choose_us.check_icon',
        'content.choose_us.people_images.0',
        'content.choose_us.people_images.1',
        'content.choose_us.people_images.2',
        'content.choose_us.people_images.3',
        'content.choose_us.people_images.4',
        'content.portfolio.bg_image',
        'content.portfolio.play_icon',
        'content.portfolio.image1',
        'content.portfolio.image2',
        'content.portfolio.image3',
        'content.about_section.bg_image',
        'content.about_section.arrow_icon',
        'content.team.default_image',
        'content.team.arrow_icon',
        'content.work_process.main_image',
        'content.work_process.arrow_icon',
        'content.work_process.shape1',
        'content.work_process.shape2',
        'content.work_process.step_icon',
        'content.testimonial.fallback_image',
        'content.testimonial.user_placeholder',
        'content.testimonial.arrow_icon',
    ];

    public function edit()
    {
        $content = HomePageSetting::getContent();
        return view('admin.home-page.edit', compact('content'));
    }

    public function update(Request $request)
    {
        $settings = HomePageSetting::instance();
        $content = array_replace_recursive(
            HomePageSetting::defaultContent(),
            $settings->content ?? [],
            $request->input('content', [])
        );

        foreach ($this->fileKeys as $key) {
            if (!$request->hasFile($key)) {
                continue;
            }
            $file = $request->file($key);
            if (!$file->isValid()) {
                continue;
            }
            $newPath = $this->uploadImage($file, str_replace(['content.', '.'], ['', '-'], $key));
            $this->setNestedValue($content, $key, $newPath);
        }

        $settings->update(['content' => $content]);

        return redirect()->route('admin.home-page.edit')
            ->with('success', 'تم حفظ محتوى الصفحة الرئيسية بنجاح');
    }

    protected function setNestedValue(array &$arr, string $dotKey, $value): void
    {
        $keys = explode('.', $dotKey);
        if (array_shift($keys) !== 'content') {
            return;
        }
        $current = &$arr;
        foreach ($keys as $i => $k) {
            $isLast = $i === count($keys) - 1;
            if ($isLast) {
                $current[$k] = $value;
                return;
            }
            if (!isset($current[$k]) || !is_array($current[$k])) {
                $current[$k] = [];
            }
            $current = &$current[$k];
        }
    }

    protected function uploadImage($file, string $prefix): string
    {
        $dir = public_path($this->uploadPath);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $ext = $file->getClientOriginalExtension() ?: 'png';
        $name = preg_replace('/[^a-z0-9_-]/i', '_', $prefix) . '_' . time() . '.' . $ext;
        $file->move($dir, $name);
        return $this->uploadPath . '/' . $name;
    }
}
