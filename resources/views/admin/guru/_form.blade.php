@php
    $isEdit = $teacher->exists;
@endphp

<form action="{{ $isEdit ? route('admin.guru.update', $teacher) : route('admin.guru.store') }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @if($isEdit)
        @method('PUT')
    @endif

    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="card-head"><h5><i class="bi bi-person-vcard me-2 text-success"></i>Data Guru / Staf</h5></div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-8">
                            <label for="name" class="form-label">Nama Lengkap &amp; Gelar <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                   id="name" name="name" value="{{ old('name', $teacher->name) }}"
                                   placeholder="Contoh: Siti Rahmawati, S.Pd." required>
                            @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="nip" class="form-label">NIP</label>
                            <input type="text" class="form-control @error('nip') is-invalid @enderror"
                                   id="nip" name="nip" value="{{ old('nip', $teacher->nip) }}"
                                   placeholder="Opsional">
                            @error('nip')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="position" class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('position') is-invalid @enderror"
                                   id="position" name="position" value="{{ old('position', $teacher->position) }}"
                                   placeholder="Contoh: Guru Kelas" required>
                            @error('position')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-6">
                            <label for="subject" class="form-label">Mata Pelajaran / Tugas</label>
                            <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                   id="subject" name="subject" value="{{ old('subject', $teacher->subject) }}"
                                   placeholder="Contoh: Kelas IV / PJOK">
                            @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>
                        <div class="col-md-4">
                            <label for="order" class="form-label">Urutan Tampil</label>
                            <input type="number" class="form-control @error('order') is-invalid @enderror"
                                   id="order" name="order" value="{{ old('order', $teacher->order) }}" min="0" max="999">
                            @error('order')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            <div class="form-text">Angka kecil tampil lebih dahulu.</div>
                        </div>
                        <div class="col-md-8 d-flex align-items-end">
                            <div class="form-check form-switch mb-2">
                                <input type="hidden" name="is_active" value="0">
                                <input class="form-check-input" type="checkbox" role="switch" id="is_active"
                                       name="is_active" value="1" @checked(old('is_active', $teacher->is_active))>
                                <label class="form-check-label" for="is_active">Tampilkan di website (aktif)</label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card mb-4">
                <div class="card-head"><h5><i class="bi bi-camera me-2 text-success"></i>Foto</h5></div>
                <div class="card-body text-center">
                    <img id="teacherPhotoPreview"
                         src="{{ $teacher->photo_url ?: asset('images/avatar.svg') }}"
                         alt="Pratinjau foto" class="mb-3"
                         style="width: 140px; height: 140px; object-fit: cover; border-radius: 50%; border: 4px solid var(--brand-50);">
                    <input type="file" class="form-control @error('photo') is-invalid @enderror"
                           id="photo" name="photo" accept="image/jpeg,image/png,image/webp"
                           data-preview="#teacherPhotoPreview">
                    @error('photo')<div class="invalid-feedback">{{ $message }}</div>@enderror
                    <div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB. Rasio 1:1 disarankan.</div>
                </div>
            </div>

            <div class="d-flex gap-2">
                <button type="submit" class="btn btn-primary flex-grow-1">
                    <i class="bi bi-save me-1"></i>{{ $isEdit ? 'Simpan Perubahan' : 'Simpan Data' }}
                </button>
                <a href="{{ route('admin.guru.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </div>
</form>
