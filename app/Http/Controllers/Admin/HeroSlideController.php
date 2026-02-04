<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HeroSlide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HeroSlideController extends Controller
{
    /** Upload path relative to public directory */
    protected string $uploadPath = 'frontend/uploads/hero-slides';

    /**
     * Display a listing of hero slides.
     */
    public function index()
    {
        $slides = HeroSlide::ordered()->get();
        return view('admin.hero-slides.index', compact('slides'));
    }

    /**
     * Show the form for creating a new slide.
     */
    public function create()
    {
        return view('admin.hero-slides.create');
    }

    /**
     * Store a newly created slide in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'background_image' => 'required|image|max:5120',
            'subtitle' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button1_text' => 'nullable|string|max:100',
            'button1_url' => 'nullable|string|max:255',
            'button2_text' => 'nullable|string|max:100',
            'button2_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? 0;

        if ($request->hasFile('background_image')) {
            $data['background_image'] = $this->uploadImage($request->file('background_image'));
        }

        HeroSlide::create($data);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'تم إضافة الشريحة بنجاح');
    }

    /**
     * Show the form for editing the specified slide.
     */
    public function edit(HeroSlide $heroSlide)
    {
        return view('admin.hero-slides.edit', compact('heroSlide'));
    }

    /**
     * Update the specified slide in storage.
     */
    public function update(Request $request, HeroSlide $heroSlide)
    {
        $validated = $request->validate([
            'background_image' => 'nullable|image|max:5120',
            'subtitle' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'button1_text' => 'nullable|string|max:100',
            'button1_url' => 'nullable|string|max:255',
            'button2_text' => 'nullable|string|max:100',
            'button2_url' => 'nullable|string|max:255',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? 0;

        if ($request->hasFile('background_image')) {
            $this->deleteImage($heroSlide->background_image);
            $data['background_image'] = $this->uploadImage($request->file('background_image'));
        }

        $heroSlide->update($data);

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'تم تحديث الشريحة بنجاح');
    }

    /**
     * Remove the specified slide from storage.
     */
    public function destroy(HeroSlide $heroSlide)
    {
        $this->deleteImage($heroSlide->background_image);
        $heroSlide->delete();

        return redirect()->route('admin.hero-slides.index')
            ->with('success', 'تم حذف الشريحة بنجاح');
    }

    /**
     * Upload image to public/frontend/uploads/hero-slides/
     */
    protected function uploadImage($file): string
    {
        $dir = public_path($this->uploadPath);
        if (!File::isDirectory($dir)) {
            File::makeDirectory($dir, 0755, true);
        }
        $imageName = time() . '_' . Str::random(8) . '.' . $file->getClientOriginalExtension();
        $file->move($dir, $imageName);
        return $this->uploadPath . '/' . $imageName;
    }

    /**
     * Delete image - supports both public path and old storage path
     */
    protected function deleteImage(?string $path): void
    {
        if (!$path) {
            return;
        }
        if (str_starts_with($path, 'frontend/uploads/')) {
            $fullPath = public_path($path);
            if (File::exists($fullPath)) {
                File::delete($fullPath);
            }
        } elseif (Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }
}
