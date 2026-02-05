<?php

namespace App\Http\Controllers\Frontend;

use App\Models\BlogCategory;
use App\Models\BlogPost;
use App\Models\BlogTag;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts with optional filters (category, tag, search).
     */
    public function index(Request $request): View
    {
        $categories = BlogCategory::active()->orderBy('order')->orderBy('name')->get();
        $tags = BlogTag::active()->orderBy('order')->orderBy('name')->get();

        $posts = BlogPost::published()
            ->with(['author', 'category'])
            ->when($request->filled('category'), function ($query) use ($request) {
                $query->whereHas('category', function ($q) use ($request) {
                    $q->where('slug', $request->category);
                });
            })
            ->when($request->filled('tag'), function ($query) use ($request) {
                $query->whereHas('tags', function ($q) use ($request) {
                    $q->where('slug', $request->tag);
                });
            })
            ->when($request->filled('q'), function ($query) use ($request) {
                $q = $request->q;
                $query->where(function ($qb) use ($q) {
                    $qb->where('title', 'like', "%{$q}%")
                        ->orWhere('excerpt', 'like', "%{$q}%")
                        ->orWhere('content', 'like', "%{$q}%");
                });
            })
            ->latest('published_at')
            ->paginate(12)
            ->withQueryString();

        return view('frontend.blog.index', compact('posts', 'categories', 'tags'));
    }

    /**
     * Display the specified blog post.
     */
    public function show(string $slug)
    {
        $post = BlogPost::published()
            ->where('slug', $slug)
            ->with(['author', 'category', 'tags'])
            ->firstOrFail();

        $post->incrementViews();

        return view('frontend.blog.show', compact('post'));
    }
}
