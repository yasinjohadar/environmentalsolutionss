<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductSize extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'name',
        'order',
    ];

    protected $casts = [
        'order' => 'integer',
    ];

    /**
     * Get the product that owns the size.
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    /**
     * Get the variants for this size.
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }
}
