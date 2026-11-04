<?php

namespace App\Http\Controllers;

use App\Models\News;

class SitemapController extends Controller
{
    public function index()
    {
        $news = News::published()->latest('published_at')->get(['slug', 'updated_at']);

        return response()
            ->view('sitemap', compact('news'))
            ->header('Content-Type', 'application/xml');
    }
}
