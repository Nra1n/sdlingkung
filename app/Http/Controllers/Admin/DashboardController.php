<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\News;
use App\Models\Teacher;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita' => News::count(),
            'berita_tayang' => News::published()->count(),
            'guru' => Teacher::active()->count(),
            'galeri' => Gallery::count(),
            'prestasi' => Achievement::count(),
            'pesan_baru' => ContactMessage::unread()->count(),
        ];

        $latestNews = News::latest()->take(5)->get();
        $latestMessages = ContactMessage::latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'latestNews', 'latestMessages'));
    }
}
