<?php

namespace App\Http\Controllers\Frontend;

use Illuminate\View\View;

class AboutController extends Controller
{
    /**
     * Display the about us page.
     */
    public function index(): View
    {
        return view('frontend.about.index');
    }
}
