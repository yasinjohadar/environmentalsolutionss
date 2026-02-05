<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductColor extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'hex_code',
        'image',
    ];

    /**
     * Get the product that owns the color.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variants for this color.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get the full URL for the color image (storage path served via storage.image.serve).
     */
    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        $path = ltrim($this->image, '/');
        if (str_starts_with($path, 'frontend/uploads/')) {
            return asset($path);
        }
        return route('storage.image.serve', ['path' => $path]);
    }
}
