<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HeroSlide extends Model
{
    protected $fillable = [
        'background_image',
        'subtitle',
        'title',
        'description',
        'button1_text',
        'button1_url',
        'button2_text',
        'button2_url',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope to get only active slides
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope to order slides by order column
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Get the full URL for the background image.
     * Supports old storage path (storage/...) and new public path (frontend/uploads/...).
     */
    public function getBackgroundImageUrlAttribute(): ?string
    {
        if (!$this->background_image) {
            return null;
        }
        if (str_starts_with($this->background_image, 'frontend/uploads/')) {
            return asset($this->background_image);
        }
        return asset('storage/' . $this->background_image);
    }
}
