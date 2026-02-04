<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TeamMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class TeamMemberController extends Controller
{
    /** Upload path relative to public directory */
    protected string $uploadPath = 'frontend/uploads/team-members';

    /**
     * Display a listing of team members.
     */
    public function index()
    {
        $members = TeamMember::ordered()->get();
        return view('admin.team-members.index', compact('members'));
    }

    /**
     * Show the form for creating a new member.
     */
    public function create()
    {
        return view('admin.team-members.create');
    }

    /**
     * Store a newly created member in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? 0;

        if ($request->hasFile('image')) {
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        TeamMember::create($data);

        return redirect()->route('admin.team-members.index')
            ->with('success', 'تم إضافة العضو بنجاح');
    }

    /**
     * Show the form for editing the specified member.
     */
    public function edit(TeamMember $teamMember)
    {
        return view('admin.team-members.edit', compact('teamMember'));
    }

    /**
     * Update the specified member in storage.
     */
    public function update(Request $request, TeamMember $teamMember)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|max:5120',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ]);

        $data = $validated;
        $data['is_active'] = $request->boolean('is_active');
        $data['order'] = $data['order'] ?? 0;

        if ($request->hasFile('image')) {
            $this->deleteImage($teamMember->image);
            $data['image'] = $this->uploadImage($request->file('image'));
        }

        $teamMember->update($data);

        return redirect()->route('admin.team-members.index')
            ->with('success', 'تم تحديث العضو بنجاح');
    }

    /**
     * Remove the specified member from storage.
     */
    public function destroy(TeamMember $teamMember)
    {
        $this->deleteImage($teamMember->image);
        $teamMember->delete();

        return redirect()->route('admin.team-members.index')
            ->with('success', 'تم حذف العضو بنجاح');
    }

    /**
     * Upload image to public/frontend/uploads/team-members/
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
