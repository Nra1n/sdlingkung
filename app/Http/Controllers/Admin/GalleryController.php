<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Support\Media;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::latest()->paginate(12);

        return view('admin.galeri.index', compact('galleries'));
    }

    public function create()
    {
        $gallery = new Gallery(['is_published' => true, 'category' => 'Kegiatan']);

        return view('admin.galeri.create', compact('gallery'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateGallery($request);
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['media_type'] === 'photo') {
            $validated['image'] = Media::store($request->file('image'), 'galeri');
            $validated['video_url'] = null;
        } else {
            $validated['image'] = null;
        }
        unset($validated['media_type']);

        Gallery::create($validated);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Konten galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery)
    {
        return view('admin.galeri.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $validated = $this->validateGallery($request, $gallery);
        $validated['is_published'] = $request->boolean('is_published');

        if ($validated['media_type'] === 'photo') {
            if ($request->hasFile('image')) {
                Media::delete($gallery->image);
                $validated['image'] = Media::store($request->file('image'), 'galeri');
            }
            $validated['video_url'] = null;
        } else {
            Media::delete($gallery->image);
            $validated['image'] = null;
        }
        unset($validated['media_type']);

        $gallery->update($validated);

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Konten galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery)
    {
        Media::delete($gallery->image);
        $gallery->delete();

        return redirect()->route('admin.galeri.index')
            ->with('success', 'Konten galeri berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateGallery(Request $request, ?Gallery $gallery = null): array
    {
        $validated = $request->validate([
            'media_type' => ['required', 'in:photo,video'],
            'title' => ['required', 'string', 'max:120'],
            'category' => ['required', 'string', 'in:'.implode(',', Gallery::CATEGORIES)],
            'description' => ['nullable', 'string', 'max:500'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:3072'],
            'video_url' => [
                'exclude_unless:media_type,video',
                'required',
                'url',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    if ($value !== null && (! is_string($value) || Gallery::youtubeEmbedUrl($value) === null)) {
                        $fail('Masukkan link video YouTube yang valid.');
                    }
                },
            ],
        ], [], [
            'media_type' => 'jenis konten',
            'title' => 'judul',
            'category' => 'kategori',
            'description' => 'deskripsi',
            'image' => 'foto',
            'video_url' => 'link video YouTube',
        ]);

        if (
            $validated['media_type'] === 'photo'
            && ! $request->hasFile('image')
            && ! filled($gallery?->image)
        ) {
            throw ValidationException::withMessages([
                'image' => 'Pilih foto untuk konten galeri.',
            ]);
        }

        return $validated;
    }
}
