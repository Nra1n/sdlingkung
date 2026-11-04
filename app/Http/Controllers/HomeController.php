<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\Gallery;
use App\Models\News;
use App\Models\SiteSetting;
use App\Models\Teacher;

class HomeController extends Controller
{
    public function index()
    {
        $site = SiteSetting::current();

        $latestNews = News::published()
            ->latest('published_at')
            ->take(3)
            ->get();

        $achievements = Achievement::published()
            ->orderByDesc('year')
            ->orderByDesc('id')
            ->take(4)
            ->get();

        $teachers = Teacher::active()->ordered()->take(4)->get();

        $galleries = Gallery::published()->latest()->take(6)->get();

        return view('home', compact('site', 'latestNews', 'achievements', 'teachers', 'galleries'));
    }
}
