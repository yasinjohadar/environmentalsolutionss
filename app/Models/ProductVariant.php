<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ProductVariant extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'color_id',
        'size_id',
        'sku',
        'price',
        'sale_price',
        'stock_quantity',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
    ];

    /**
     * Get the product that owns the variant.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the color of the variant.
     */
    public function color()
    {
        return $this->belongsTo(ProductColor::class);
    }

    /**
     * Get the size of the variant.
     */
    public function size()
    {
        return $this->belongsTo(ProductSize::class);
    }

    /**
     * Get the current price (sale price if available, otherwise regular price).
     */
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price ?? $this->product->price;
    }

    /**
     * Get the full URL for the variant image.
     */
    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return Storage::url($this->image);
        }
        
        // Fallback to color image
        if ($this->color && $this->color->image) {
            return Storage::url($this->color->image);
        }
        
        // Fallback to product main image
        return $this->product->main_image_url;
    }

    /**
     * Get variant name (Color + Size).
     */
    public function getVariantNameAttribute()
    {
        $parts = [];
        if ($this->color) {
            $parts[] = $this->color->name;
        }
        if ($this->size) {
            $parts[] = $this->size->name;
        }
        return implode(' - ', $parts) ?: 'افتراضي';
    }
}
