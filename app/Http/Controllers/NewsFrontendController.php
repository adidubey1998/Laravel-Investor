<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class NewsFrontendController extends Controller
{
    public function index()
    {
        $news = News::where('status', 1)
                    ->orderBy('sort_order')
                    ->latest()
                    ->get();

        return view('welcome', compact('news'));
    }

    public function show($slug)
    {
        $news = News::where('slug', $slug)
                    ->where('status', 1)
                    ->firstOrFail();

        return view('welcome', compact('news'));
    }
}
