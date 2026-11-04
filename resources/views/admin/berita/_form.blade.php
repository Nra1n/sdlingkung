@php
    $isEdit = $news->exists;
@endphp

<form action="{{ $isEdit ? route('admin.berita.update', $news) : route('admin.berita.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="card-head">
                    <h5><i class="bi bi-pencil-square me-2 text-success"></i>Isi Berita</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Berita <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $news->title) }}"
                               placeholder="Contoh: Penerimaan Siswa Baru Tahun Ajaran 2026/2027" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Slug URL dibuat otomatis dari judul.</div>
                    </div>

                    <div class="mb-3">
                        <label for="excerpt" class="form-label">Ringkasan</label>
                        <textarea class="form-control @error('excerpt') is-invalid @enderror"
                                  id="excerpt" name="excerpt" rows="2" maxlength="500"
                                  placeholder="Ringkasan singkat yang tampil pada kartu berita...">{{ old('excerpt', $news->excerpt) }}</textarea>
                        @error('excerpt')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Opsional. Maksimal 500 karakter.</div>
                    </div>

                    <div class="mb-0">
                        <label for="content" class="form-label">Isi Berita <span class="text-danger">*</span></label>
                        <textarea class="form-control @error('content') is-invalid @enderror"
                                  id="content" name="content" rows="14" required
                                  placeholder="Tulis isi berita di sini...">{{ old('content', $news->content) }}</textarea>
                        @error('content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Gunakan enter dua kali untuk membuat paragraf baru.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="card-head"><h5><i class="bi bi-toggles me-2 text-success"></i>Publikasi</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            @foreach(\App\Models\News::CATEGORIES as $category)
                                <option value="{{ $category }}" @selected(old('category', $news->category) === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="published_at" class="form-label">Tanggal &amp; Waktu Terbit</label>
                        <input type="datetime-local" class="form-control @error('published_at') is-invalid @enderror"
                               id="published_at" name="published_at"
                               value="{{ old('published_at', $news->published_at?->format('Y-m-d\TH:i')) }}">
                        @error('published_at')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Kosongkan untuk menggunakan waktu sekarang.</div>
                    </div>

                    <div class="form-check form-switch">
                        <input type="hidden" name="is_published" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_published"
                               name="is_published" value="1" @checked(old('is_published', $news->is_published))>
                        <label class="form-check-label" for="is_published">Tayangkan di website</label>
                    </div>
                </div>
            </div>

            <div class="admin-card mb-4">
                <div class="card-head"><h5><i class="bi bi-image me-2 text-success"></i>Gambar Utama</h5></div>
                <div class="card-body">
                    <img id="newsImagePreview" src="{{ $news->image_url }}" alt="Pratinjau gambar" class="admin-thumb-preview mb-3">
                    <input type="file" class="form-control @error('image') is-invalid @enderror"
                           id="image" name="image" accept="image/jpeg,image/png,image/webp"
                           data-preview="#newsImagePreview">
                    @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">JPG, PNG, atau WEBP. Maksimal 3 MB. Disarankan rasio 16:10.</div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-save me-1"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Berita' }}
                </button>
                <a href="{{ route('admin.berita.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>
