@php
    $isEdit = $achievement->exists;
@endphp

<form action="{{ $isEdit ? route('admin.prestasi.update', $achievement) : route('admin.prestasi.store') }}" method="POST">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="card-head"><h5><i class="bi bi-trophy me-2 text-success"></i>Detail Prestasi</h5></div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Judul Prestasi <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror"
                               id="title" name="title" value="{{ old('title', $achievement->title) }}"
                               placeholder="Contoh: Juara 1 Lomba Cerdas Cermat" required>
                        @error('title')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="level" class="form-label">Tingkat <span class="text-danger">*</span></label>
                            <select class="form-select @error('level') is-invalid @enderror" id="level" name="level" required>
                                @foreach(\App\Models\Achievement::LEVELS as $level)
                                    <option value="{{ $level }}" @selected(old('level', $achievement->level) === $level)>{{ $level }}</option>
                                @endforeach
                            </select>
                            @error('level')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="year" class="form-label">Tahun <span class="text-danger">*</span></label>
                            <input type="number" class="form-control @error('year') is-invalid @enderror"
                                   id="year" name="year" value="{{ old('year', $achievement->year) }}"
                                   min="1900" max="2100" required>
                            @error('year')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                    </div>

                    <div class="mt-3">
                        <label for="description" class="form-label">Deskripsi</label>
                        <textarea class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description" rows="4"
                                  placeholder="Keterangan singkat tentang prestasi...">{{ old('description', $achievement->description) }}</textarea>
                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="card-head"><h5><i class="bi bi-toggles me-2 text-success"></i>Publikasi</h5></div>
                <div class="card-body">
                    <div class="form-check form-switch">
                        <input type="hidden" name="is_published" value="0">
                        <input class="form-check-input" type="checkbox" role="switch" id="is_published"
                               name="is_published" value="1" @checked(old('is_published', $achievement->is_published))>
                        <label class="form-check-label" for="is_published">Tayangkan di website</label>
                    </div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-save me-1"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Prestasi' }}
                </button>
                <a href="{{ route('admin.prestasi.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>
