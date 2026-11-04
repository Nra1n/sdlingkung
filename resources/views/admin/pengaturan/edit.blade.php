@extends('layouts.admin')

@section('title', 'Pengaturan Website')
@section('heading', 'Pengaturan Website')
@section('subheading', 'Identitas sekolah, profil, dan kontak yang tampil di seluruh halaman')

@section('konten')
    <form action="{{ route('admin.pengaturan.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="row g-4">
            <div class="col-lg-8">
                {{-- Identitas --}}
                <div class="admin-card mb-4">
                    <div class="card-head"><h5><i class="bi bi-building me-2 text-success"></i>Identitas Sekolah</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="nama_sekolah" class="form-label">Nama Sekolah <span class="text-danger">*</span></label>
                                <input type="text" class="form-control @error('nama_sekolah') is-invalid @enderror"
                                       id="nama_sekolah" name="nama_sekolah"
                                       value="{{ old('nama_sekolah', $site->nama_sekolah) }}" required>
                                @error('nama_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="akreditasi" class="form-label">Akreditasi</label>
                                <input type="text" class="form-control @error('akreditasi') is-invalid @enderror"
                                       id="akreditasi" name="akreditasi"
                                       value="{{ old('akreditasi', $site->akreditasi) }}" placeholder="A">
                                @error('akreditasi')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-12">
                                <label for="tagline" class="form-label">Tagline / Slogan Beranda</label>
                                <input type="text" class="form-control @error('tagline') is-invalid @enderror"
                                       id="tagline" name="tagline"
                                       value="{{ old('tagline', $site->tagline) }}"
                                       placeholder="Membangun Generasi Cerdas &amp; Berkarakter">
                                @error('tagline')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="tahun_berdiri" class="form-label">Tahun Berdiri</label>
                                <input type="number" class="form-control" id="tahun_berdiri" name="tahun_berdiri"
                                       value="{{ old('tahun_berdiri', $site->tahun_berdiri) }}" min="1900" max="2100">
                            </div>
                            <div class="col-md-4">
                                <label for="jumlah_siswa" class="form-label">Jumlah Siswa</label>
                                <input type="number" class="form-control" id="jumlah_siswa" name="jumlah_siswa"
                                       value="{{ old('jumlah_siswa', $site->jumlah_siswa) }}" min="0">
                            </div>
                            <div class="col-md-4">
                                <label for="jumlah_guru" class="form-label">Jumlah Guru &amp; Staf</label>
                                <input type="number" class="form-control" id="jumlah_guru" name="jumlah_guru"
                                       value="{{ old('jumlah_guru', $site->jumlah_guru) }}" min="0">
                            </div>
                            <div class="col-md-4">
                                <label for="jumlah_kelas" class="form-label">Jumlah Rombongan Belajar</label>
                                <input type="number" class="form-control" id="jumlah_kelas" name="jumlah_kelas"
                                       value="{{ old('jumlah_kelas', $site->jumlah_kelas) }}" min="0">
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Kontak --}}
                <div class="admin-card mb-4">
                    <div class="card-head"><h5><i class="bi bi-telephone me-2 text-success"></i>Kontak &amp; Lokasi</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label for="alamat" class="form-label">Alamat Lengkap</label>
                                <textarea class="form-control" id="alamat" name="alamat" rows="2">{{ old('alamat', $site->alamat) }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label for="telepon" class="form-label">Telepon</label>
                                <input type="text" class="form-control" id="telepon" name="telepon"
                                       value="{{ old('telepon', $site->telepon) }}">
                            </div>
                            <div class="col-md-6">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control @error('email') is-invalid @enderror"
                                       id="email" name="email" value="{{ old('email', $site->email) }}">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-6">
                                <label for="whatsapp" class="form-label">Nomor WhatsApp</label>
                                <input type="text" class="form-control" id="whatsapp" name="whatsapp"
                                       value="{{ old('whatsapp', $site->whatsapp) }}" placeholder="628xxxxxxxxxx">
                                <div class="form-text">Gunakan format 62... agar tautan WhatsApp berfungsi.</div>
                            </div>
                            <div class="col-md-6">
                                <label for="jam_operasional" class="form-label">Jam Operasional</label>
                                <input type="text" class="form-control" id="jam_operasional" name="jam_operasional"
                                       value="{{ old('jam_operasional', $site->jam_operasional) }}">
                            </div>
                            <div class="col-12">
                                <label for="maps_embed" class="form-label">Peta Google Maps</label>
                                <textarea class="form-control" id="maps_embed" name="maps_embed" rows="2"
                                          placeholder="Tempel URL embed atau kode iframe Google Maps">{{ old('maps_embed', $site->maps_embed) }}</textarea>
                                <div class="form-text">
                                    Dapat menempel kode &lt;iframe&gt; dari Google Maps; sistem akan mengambil URL src secara otomatis.
                                </div>
                            </div>
                            <div class="col-md-4">
                                <label for="facebook" class="form-label">Facebook</label>
                                <input type="url" class="form-control @error('facebook') is-invalid @enderror"
                                       id="facebook" name="facebook" value="{{ old('facebook', $site->facebook) }}">
                                @error('facebook')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="instagram" class="form-label">Instagram</label>
                                <input type="url" class="form-control @error('instagram') is-invalid @enderror"
                                       id="instagram" name="instagram" value="{{ old('instagram', $site->instagram) }}">
                                @error('instagram')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-md-4">
                                <label for="youtube" class="form-label">YouTube</label>
                                <input type="url" class="form-control @error('youtube') is-invalid @enderror"
                                       id="youtube" name="youtube" value="{{ old('youtube', $site->youtube) }}">
                                @error('youtube')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Profil --}}
                <div class="admin-card mb-4">
                    <div class="card-head"><h5><i class="bi bi-journal-text me-2 text-success"></i>Profil Sekolah</h5></div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-8">
                                <label for="kepala_sekolah" class="form-label">Nama Kepala Sekolah</label>
                                <input type="text" class="form-control" id="kepala_sekolah" name="kepala_sekolah"
                                       value="{{ old('kepala_sekolah', $site->kepala_sekolah) }}">
                            </div>
                            <div class="col-12">
                                <label for="sambutan" class="form-label">Sambutan Kepala Sekolah</label>
                                <textarea class="form-control" id="sambutan" name="sambutan" rows="5">{{ old('sambutan', $site->sambutan) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="visi" class="form-label">Visi</label>
                                <textarea class="form-control" id="visi" name="visi" rows="3">{{ old('visi', $site->visi) }}</textarea>
                            </div>
                            <div class="col-12">
                                <label for="misi" class="form-label">Misi</label>
                                <textarea class="form-control" id="misi" name="misi" rows="6">{{ old('misi', $site->misi) }}</textarea>
                                <div class="form-text">Tulis satu poin misi per baris. Setiap baris otomatis menjadi item daftar.</div>
                            </div>
                            <div class="col-12">
                                <label for="sejarah" class="form-label">Sejarah Singkat</label>
                                <textarea class="form-control" id="sejarah" name="sejarah" rows="6">{{ old('sejarah', $site->sejarah) }}</textarea>
                                <div class="form-text">Pisahkan paragraf dengan enter dua kali.</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <div class="admin-card mb-4">
                    <div class="card-head"><h5><i class="bi bi-image me-2 text-success"></i>Gambar Latar Hero</h5></div>
                    <div class="card-body">
                        <img id="heroImagePreview"
                             src="{{ \App\Support\Media::url($site->hero_image, 'images/seed/hero.jpg') }}"
                             alt="Pratinjau gambar latar hero" class="admin-thumb-preview mb-3" style="max-width: 100%;">
                        <input type="file" class="form-control @error('hero_image') is-invalid @enderror"
                               id="hero_image" name="hero_image"
                               accept="image/jpeg,image/png,image/webp" data-preview="#heroImagePreview">
                        @error('hero_image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">JPG, PNG, atau WEBP. Maksimal 4 MB. Disarankan ukuran 1600&times;900 px.</div>

                        @if($site->hero_image)
                            <div class="form-check mt-3 text-start">
                                <input class="form-check-input" type="checkbox" value="1"
                                       id="hapus_hero_image" name="hapus_hero_image">
                                <label class="form-check-label small" for="hapus_hero_image">
                                    Hapus gambar kustom, kembali ke gambar bawaan
                                </label>
                            </div>
                        @endif
                    </div>
                </div>

                <div class="admin-card mb-4">
                    <div class="card-head"><h5><i class="bi bi-camera me-2 text-success"></i>Foto Kepala Sekolah</h5></div>
                    <div class="card-body text-center">
                        <img id="headmasterPreview"
                             src="{{ $site->foto_kepala_sekolah ? \App\Support\Media::url($site->foto_kepala_sekolah) : asset('images/avatar.svg') }}"
                             alt="Foto kepala sekolah" class="mb-3"
                             style="width: 130px; height: 130px; object-fit: cover; border-radius: 50%; border: 4px solid var(--brand-50);">
                        <input type="file" class="form-control @error('foto_kepala_sekolah') is-invalid @enderror"
                               id="foto_kepala_sekolah" name="foto_kepala_sekolah"
                               accept="image/jpeg,image/png,image/webp" data-preview="#headmasterPreview">
                        @error('foto_kepala_sekolah')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        <div class="form-text">JPG, PNG, atau WEBP. Maksimal 2 MB.</div>
                    </div>
                </div>

                <div class="admin-card">
                    <div class="card-body">
                        <button type="submit" class="btn btn-primary w-100">
                            <i class="bi bi-save me-1"></i>Simpan Pengaturan
                        </button>
                        <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-outline-secondary w-100 mt-2">
                            <i class="bi bi-eye me-1"></i>Pratinjau Website
                        </a>
                        <p class="small text-muted mt-3 mb-0">
                            Perubahan akan langsung tampil di seluruh halaman website setelah disimpan.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection
