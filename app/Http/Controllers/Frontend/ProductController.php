<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of active products with optional category filter.
     */
    public function index(Request $request): View
    {
        $categories = Category::active()->ordered()->get();

        $products = Product::active()
            ->with(['category', 'images'])
            ->latest()
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%' . trim($request->q) . '%';
                $query->where(function ($q) use ($term) {
                    $q->where('name', 'like', $term)
                        ->orWhere('short_description', 'like', $term)
                        ->orWhere('description', 'like', $term)
                        ->orWhereHas('category', fn ($c) => $c->where('name', 'like', $term));
                });
            })
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->paginate(12)
            ->withQueryString();

        return view('frontend.products.index', compact('products', 'categories'));
    }

    /**
     * Display the specified product by slug.
     */
    public function show(string $slug): View
    {
        $product = Product::where('slug', $slug)
            ->active()
            ->with([
                'category',
                'images',
                'colors',
                'sizes',
                'variants' => fn ($q) => $q->with(['color', 'size']),
            ])
            ->withCount('approvedReviews')
            ->with(['approvedReviews' => fn ($q) => $q->latest()->take(5)])
            ->firstOrFail();

        $relatedProducts = $product->category_id
            ? Product::active()
                ->where('category_id', $product->category_id)
                ->whereKeyNot($product->id)
                ->with(['category', 'images'])
                ->inRandomOrder()
                ->limit(8)
                ->get()
            : collect();

        return view('frontend.products.show', compact('product', 'relatedProducts'));
    }
}
