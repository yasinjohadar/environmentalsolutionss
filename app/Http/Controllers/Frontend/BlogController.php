<?php

namespace App\Http\Controllers\Frontend;

use App\Models\BlogPost;

class BlogController extends Controller
{
    /**
     * Display a listing of published blog posts.
     */
    public function index()
    {
        $posts = BlogPost::published()
            ->with(['author', 'category'])
            ->latest('published_at')
            ->paginate(12);

        return view('frontend.blog.index', compact('posts'));
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
