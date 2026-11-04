<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $category = (string) $request->query('kategori');

        $photos = Gallery::published()
            ->photos()
            ->category($category)
            ->latest()
            ->paginate(12, ['*'], 'halaman_foto')
            ->withQueryString();

        $videos = Gallery::published()
            ->videos()
            ->category($category)
            ->latest()
            ->paginate(12, ['*'], 'halaman_video')
            ->withQueryString();

        $categories = Gallery::published()
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        return view('galeri', compact('photos', 'videos', 'categories', 'category'));
    }
}
