<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'sku',
        'barcode',
        'short_description',
        'description',
        'main_image',
        'price',
        'sale_price',
        'wholesale_price',
        'stock_quantity',
        'min_order_quantity',
        'weight',
        'dimensions',
        'category_id',
        'status',
        'featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'og_image',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'sale_price' => 'decimal:2',
        'wholesale_price' => 'decimal:2',
        'stock_quantity' => 'integer',
        'min_order_quantity' => 'integer',
        'weight' => 'decimal:2',
        'featured' => 'boolean',
    ];

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($product) {
            if (empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            if (empty($product->created_by)) {
                $product->created_by = auth()->id();
            }
        });

        static::updating(function ($product) {
            if ($product->isDirty('name') && empty($product->slug)) {
                $product->slug = Str::slug($product->name);
            }
            $product->updated_by = auth()->id();
        });
    }

    /**
     * Get the category that owns the product.
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the product images.
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    /**
     * Get the main image.
     */
    public function mainImage()
    {
        return $this->hasOne(ProductImage::class)->where('is_main', true)
            ->orWhere('product_id', $this->id)
            ->orderBy('order')
            ->limit(1);
    }

    /**
     * Get the product colors.
     */
    public function colors()
    {
        return $this->hasMany(ProductColor::class);
    }

    /**
     * Get the product sizes.
     */
    public function sizes()
    {
        return $this->hasMany(ProductSize::class)->orderBy('order');
    }

    /**
     * Get the product variants.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get the reviews for the product.
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    /**
     * Get the approved reviews for the product.
     */
    public function approvedReviews()
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }

    /**
     * Get the user who created the product.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get the user who last updated the product.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    /**
     * Scope a query to only include active products.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured products.
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include products in stock.
     */
    public function scopeInStock($query)
    {
        return $query->where('stock_quantity', '>', 0);
    }

    /**
     * Get the full URL for the main image.
     */
    public function getMainImageUrlAttribute()
    {
        if ($this->main_image) {
            return Storage::url($this->main_image);
        }
        
        // Try to get from images relationship
        $mainImage = $this->images()->where('is_main', true)->first();
        if ($mainImage) {
            return Storage::url($mainImage->image_path);
        }
        
        $firstImage = $this->images()->first();
        if ($firstImage) {
            return Storage::url($firstImage->image_path);
        }
        
        return null;
    }

    /**
     * Get the formatted price.
     */
    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 2) . ' ر.س';
    }

    /**
     * Get the current price (sale price if available, otherwise regular price).
     */
    public function getCurrentPriceAttribute()
    {
        return $this->sale_price ?? $this->price;
    }

    /**
     * Get the discount percentage.
     */
    public function getDiscountPercentageAttribute()
    {
        if ($this->sale_price && $this->price > 0) {
            return round((($this->price - $this->sale_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Check if product is on sale.
     */
    public function isOnSale()
    {
        return $this->sale_price !== null && $this->sale_price < $this->price;
    }

    /**
     * Check if product has variants.
     */
    public function hasVariants()
    {
        return $this->variants()->count() > 0;
    }

    /**
     * Get the lowest price (considering variants).
     */
    public function getLowestPrice()
    {
        if ($this->hasVariants()) {
            $minVariantPrice = $this->variants()->min('sale_price') ?? $this->variants()->min('price');
            if ($minVariantPrice) {
                return min($this->current_price, $minVariantPrice);
            }
        }
        return $this->current_price;
    }

    /**
     * Check if product is in stock.
     */
    public function isInStock()
    {
        if ($this->hasVariants()) {
            return $this->variants()->sum('stock_quantity') > 0;
        }
        return $this->stock_quantity > 0;
    }

    /**
     * Get average rating.
     */
    public function getAverageRatingAttribute()
    {
        return $this->approvedReviews()->avg('rating') ?? 0;
    }

    /**
     * Get total reviews count.
     */
    public function getTotalReviewsCountAttribute()
    {
        return $this->approvedReviews()->count();
    }
}
