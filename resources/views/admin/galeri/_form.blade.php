@php
    $isEdit = $gallery->exists;
    $mediaType = old('media_type', $gallery->video_url ? 'video' : 'photo');
@endphp

<form action="{{ $isEdit ? route('admin.galeri.update', $gallery) : route('admin.galeri.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="admin-card">
                <div class="card-head"><h5><i class="bi bi-collection me-2 text-success"></i>Tambah Konten</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="media_type" class="form-label">Jenis Konten <span class="text-danger">*</span></label>
                        <select class="form-select @error('media_type') is-invalid @enderror" id="media_type" name="media_type" required>
                            <option value="photo" @selected($mediaType === 'photo')>Foto</option>
                            <option value="video" @selected($mediaType === 'video')>Video YouTube</option>
                        </select>
                        @error('media_type')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div data-media-type-panel="photo">
                        @if($gallery->image)
                            <img id="galleryPreview" src="{{ $gallery->image_url }}" alt="Pratinjau foto"
                                 class="admin-thumb-preview mb-3" style="max-width: 100%;">
                        @else
                            <img id="galleryPreview" src="" alt="Pratinjau foto"
                                 class="admin-thumb-preview mb-3 d-none" style="max-width: 100%;">
                        @endif
                        <label for="image" class="form-label">File Foto <span class="text-danger">*</span></label>
                        <input type="file" class="form-control @error('image') is-invalid @enderror"
                               id="image" name="image" accept="image/jpeg,image/png,image/webp"
                               data-preview="#galleryPreview" data-has-image="{{ $gallery->image ? '1' : '0' }}">
                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">JPG, PNG, atau WEBP. Maksimal 3 MB. Rasio 4:3 disarankan.</div>
                    </div>

                    <div data-media-type-panel="video">
                        <label for="video_url" class="form-label">Link Video YouTube <span class="text-danger">*</span></label>
                        <input type="url" class="form-control @error('video_url') is-invalid @enderror"
                               id="video_url" name="video_url" value="{{ old('video_url', $gallery->video_url) }}"
                               placeholder="https://www.youtube.com/watch?v=..." inputmode="url">
                        @error('video_url')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">Tempel link video YouTube, misalnya dari youtube.com atau youtu.be.</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="admin-card mb-4">
                <div class="card-head"><h5><i class="bi bi-info-circle me-2 text-success"></i>Keterangan</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Konten <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $gallery->title) }}"
                               placeholder="Contoh: Kegiatan Pramuka" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="category" class="form-label">Kategori <span class="text-danger">*</span></label>
                        <select class="form-select @error('category') is-invalid @enderror" id="category" name="category" required>
                            @foreach(\App\Models\Gallery::CATEGORIES as $category)
                                <option value="{{ $category }}" @selected(old('category', $gallery->category) === $category)>{{ $category }}</option>
                            @endforeach
                        </select>
                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">Deskripsi Singkat</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="3"
                                  placeholder="Keterangan tambahan (opsional)">{{ old('description', $gallery->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="form-check form-switch">
                        <input type="hidden" name="is_published" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_published"
                               name="is_published" value="1" @checked(old('is_published', $gallery->is_published))>
                        <label class="form-check-label" for="is_published">Tayangkan di website</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-save me-1"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Tambah Konten' }}
                </button>
                <a href="{{ route('admin.galeri.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>

@push('scripts')
    <script>
        (() => {
            const typeSelect = document.getElementById('media_type');
            const imageInput = document.getElementById('image');
            const videoInput = document.getElementById('video_url');

            if (!typeSelect || !imageInput || !videoInput) return;

            const updateMediaFields = () => {
                const isPhoto = typeSelect.value === 'photo';
                document.querySelectorAll('[data-media-type-panel]').forEach((panel) => {
                    panel.hidden = panel.dataset.mediaTypePanel !== typeSelect.value;
                });
                imageInput.required = isPhoto && imageInput.dataset.hasImage !== '1';
                videoInput.required = !isPhoto;
            };

            typeSelect.addEventListener('change', updateMediaFields);
            updateMediaFields();
        })();
    </script>
@endpush
