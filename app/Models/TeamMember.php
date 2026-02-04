<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeamMember extends Model
{
    protected $fillable = [
        'name',
        'title',
        'image',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope to get only active members
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order members by order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get the full URL for the member image.
     * Supports frontend/uploads/ and storage/ paths.
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image) {
            return asset('frontend/assets/img/HomeCone/team-img1.png');
        }
        $path = ltrim($this->image, '/');
        if (str_starts_with($path, 'frontend/uploads/')) {
            return asset($path);
        }
        return route('storage.image.serve', ['path' => $path]);
    }
}
