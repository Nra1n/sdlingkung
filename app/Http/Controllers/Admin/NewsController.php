<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $search = trim((string) $request->query('q'));

        $news = News::query()
            ->search($search)
            ->latest('created_at')
            ->paginate(10)
            ->withQueryString();

        return view('admin.berita.index', compact('news', 'search'));
    }

    public function create()
    {
        $news = new News(['is_published' => true, 'category' => 'Umum']);

        return view('admin.berita.create', compact('news'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateNews($request);
        $validated['user_id'] = $request->user()->id;
        $validated['slug'] = News::uniqueSlug($validated['title']);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $this->publishedAt($request);

        if ($request->hasFile('image')) {
            $validated['image'] = Media::store($request->file('image'), 'berita');
        }

        News::create($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil ditambahkan.');
    }

    public function edit(News $news)
    {
        return view('admin.berita.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $validated = $this->validateNews($request);
        $validated['slug'] = News::uniqueSlug($validated['title'], $news->id);
        $validated['is_published'] = $request->boolean('is_published');
        $validated['published_at'] = $this->publishedAt($request);

        if ($request->hasFile('image')) {
            Media::delete($news->image);
            $validated['image'] = Media::store($request->file('image'), 'berita');
        }

        $news->update($validated);

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil diperbarui.');
    }

    public function destroy(News $news)
    {
        Media::delete($news->image);
        $news->delete();

        return redirect()->route('admin.berita.index')
            ->with('success', 'Berita berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateNews(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'in:'.implode(',', News::CATEGORIES)],
            'excerpt' => ['nullable', 'string', 'max:500'],
            'content' => ['required', 'string', 'min:30'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'published_at' => ['nullable', 'date'],
        ], [], [
            'title' => 'judul',
            'category' => 'kategori',
            'excerpt' => 'ringkasan',
            'content' => 'isi berita',
            'image' => 'gambar',
            'published_at' => 'tanggal terbit',
        ]);
    }

    private function publishedAt(Request $request): Carbon
    {
        return $request->filled('published_at')
            ? Carbon::parse($request->input('published_at'))
            : now();
    }
}
