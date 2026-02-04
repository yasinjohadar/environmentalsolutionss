<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'image_path',
        'alt_text',
        'order',
        'is_main',
    ];

    protected $casts = [
        'order' => 'integer',
        'is_main' => 'boolean',
    ];

    /**
     * Get the product that owns the image.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the full URL for the image (via Laravel route to avoid 403).
     */
    public function getImageUrlAttribute(): ?string
    {
        if (!$this->image_path) {
            return null;
        }
        $path = ltrim($this->image_path, '/');
        if (str_starts_with($path, 'frontend/uploads/')) {
            return asset($path);
        }
        return route('storage.image.serve', ['path' => $path]);
    }
}
