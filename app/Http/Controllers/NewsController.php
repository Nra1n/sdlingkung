<?php

namespace App\Http\Controllers;

use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));
        $category = (string) $request->query('kategori');

        $news = News::published()
            ->search($search)
            ->category($category)
            ->latest('published_at')
            ->paginate(6)
            ->withQueryString();

        $categories = News::published()
            ->selectRaw('category, COUNT(*) as total')
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        $popular = News::published()
            ->orderByDesc('views')
            ->take(4)
            ->get();

        return view('berita.index', compact('news', 'categories', 'popular', 'search', 'category'));
    }

    public function show(string $slug)
    {
        $news = News::published()->where('slug', $slug)->firstOrFail();

        // Hitung kunjungan tanpa memicu update timestamp.
        $news->incrementQuietly('views');

        $related = News::published()
            ->where('id', '!=', $news->id)
            ->where('category', $news->category)
            ->latest('published_at')
            ->take(3)
            ->get();

        if ($related->count() < 3) {
            $related = $related->merge(
                News::published()
                    ->where('id', '!=', $news->id)
                    ->whereNotIn('id', $related->pluck('id'))
                    ->latest('published_at')
                    ->take(3 - $related->count())
                    ->get()
            );
        }

        return view('berita.show', compact('news', 'related'));
    }
}
