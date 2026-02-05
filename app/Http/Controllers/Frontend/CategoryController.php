<?php

namespace App\Http\Controllers\Frontend;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of active categories with optional filters.
     */
    public function index(Request $request): View
    {
        $query = Category::active()
            ->ordered()
            ->withCount('products')
            ->with('parent');

        if ($request->filled('type') && $request->type === 'root') {
            $query->root();
        }

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $categories = $query->get();

        return view('frontend.categories.index', compact('categories'));
    }
}
