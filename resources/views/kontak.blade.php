@extends('layouts.main')

@section('title', 'Kontak')
@section('meta_description', 'Hubungi ' . $site->nama_sekolah . ' — alamat, telepon, email, dan formulir pesan online.')

@section('konten')
    @include('partials.page-header', [
        'title' => 'Hubungi Kami',
        'subtitle' => 'Sampaikan pertanyaan, saran, atau kebutuhan informasi seputar sekolah. Kami siap membantu.',
        'breadcrumb' => [['label' => 'Kontak']],
    ])

    <section class="section">
        <div class="container">
            <div class="contact-grid">
                <div class="card-soft contact-card">
                    <span class="icon-box"><i class="bi bi-geo-alt"></i></span>
                    <div>
                        <h6>Alamat Sekolah</h6>
                        <p>{{ $site->alamat }}</p>
                    </div>
                </div>
                <div class="card-soft contact-card">
                    <span class="icon-box accent"><i class="bi bi-telephone"></i></span>
                    <div>
                        <h6>Telepon</h6>
                        <p><a href="tel:{{ preg_replace('/\s+/', '', $site->telepon) }}">{{ $site->telepon }}</a></p>
                        <span class="contact-note">Hubungi pada jam operasional sekolah.</span>
                    </div>
                </div>
                <div class="card-soft contact-card">
                    <span class="icon-box"><i class="bi bi-envelope"></i></span>
                    <div>
                        <h6>Email</h6>
                        <p><a href="mailto:{{ $site->email }}">{{ $site->email }}</a></p>
                        <span class="contact-note">Dibalas maksimal 1&times;24 jam kerja.</span>
                    </div>
                </div>
                <div class="card-soft contact-card">
                    <span class="icon-box accent"><i class="bi bi-whatsapp"></i></span>
                    <div>
                        <h6>WhatsApp</h6>
                        <p><a href="{{ $site->whatsapp_link }}" target="_blank" rel="noopener">Chat langsung dengan sekolah</a></p>
                        <span class="contact-note">Respon cepat pada jam kerja.</span>
                    </div>
                </div>
            </div>

            <div class="row g-4 g-lg-5">
                {{-- Formulir pesan --}}
                <div class="col-lg-7">
                    <div class="card-soft p-4 p-lg-5">
                        <div class="section-eyebrow">Formulir Pesan</div>
                        <h2 class="section-title" style="font-size: 1.6rem;">Kirim Pesan kepada Kami</h2>
                        <p class="section-lead mb-4" style="font-size: .92rem;">
                            Lengkapi formulir di bawah ini. Pesan Anda akan masuk ke panel admin sekolah
                            dan dibalas melalui email atau telepon.
                        </p>

                        <form action="{{ route('kontak.store') }}" method="POST" novalidate>
                            @csrf
                            {{-- Honeypot anti-spam: disembunyikan dari pengguna --}}
                            <div class="d-none" aria-hidden="true">
                                <label for="website">Website</label>
                                <input type="text" id="website" name="website" tabindex="-1" autocomplete="off">
                            </div>

                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label for="name" class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                           id="name" name="name" value="{{ old('name') }}" required
                                           placeholder="Contoh: Ahmad Subandi">
                                    @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="email" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           id="email" name="email" value="{{ old('email') }}" required
                                           placeholder="nama@email.com">
                                    @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="phone" class="form-label">Nomor Telepon/WhatsApp</label>
                                    <input type="text" class="form-control @error('phone') is-invalid @enderror"
                                           id="phone" name="phone" value="{{ old('phone') }}"
                                           placeholder="08xxxxxxxxxx">
                                    @error('phone')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-md-6">
                                    <label for="subject" class="form-label">Subjek <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('subject') is-invalid @enderror"
                                           id="subject" name="subject" value="{{ old('subject', $topik) }}" required
                                           placeholder="Contoh: Informasi PPDB">
                                    @error('subject')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                </div>
                                <div class="col-12">
                                    <label for="message" class="form-label">Pesan <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('message') is-invalid @enderror"
                                              id="message" name="message" rows="5" required
                                              placeholder="Tuliskan pertanyaan atau pesan Anda...">{{ old('message') }}</textarea>
                                    @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    <div class="form-text">Minimal 10 karakter. Mohon tidak mencantumkan data pribadi yang sensitif.</div>
                                </div>
                                <div class="col-12">
                                    <div class="d-flex flex-wrap align-items-center justify-content-between gap-2">
                                        <button type="submit" class="btn btn-primary">
                                            <i class="bi bi-send me-2"></i>Kirim Pesan
                                        </button>
                                        <span class="contact-reply">
                                            <i class="bi bi-clock-history"></i>
                                            Dibalas maksimal 1&times;24 jam kerja
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                {{-- Peta & info tambahan --}}
                <div class="col-lg-5">
                    <div class="map-block mb-4">
                        <div class="map-frame">
                            @if($site->maps_embed)
                                <iframe src="{{ $site->maps_embed }}" title="Lokasi {{ $site->nama_sekolah }}"
                                        loading="lazy" referrerpolicy="no-referrer-when-downgrade"
                                        allowfullscreen></iframe>
                            @else
                                <div class="d-flex align-items-center justify-content-center bg-light text-muted" style="height: 380px;">
                                    Peta lokasi belum diatur.
                                </div>
                            @endif
                        </div>
                        <a class="map-link" href="https://www.google.com/maps/search/?api=1&amp;query={{ urlencode($site->alamat) }}"
                           target="_blank" rel="noopener">
                            <i class="bi bi-geo-alt me-1"></i>Buka di Google Maps
                        </a>
                    </div>

                    <div class="sidebar-card" id="jam-operasional">
                        <h6>Jam Operasional</h6>
                        <div class="hours-highlight">
                            <i class="bi bi-clock"></i>
                            <div>
                                <span class="hours-label">Hari &amp; jam layanan</span>
                                <strong>{{ $site->jam_operasional }}</strong>
                            </div>
                        </div>
                        <div class="hours-row mt-3">
                            <span>Minggu &amp; hari libur nasional</span>
                            <span class="badge-soft danger">Tutup</span>
                        </div>
                        <p class="contact-note mt-3 mb-3">
                            <i class="bi bi-info-circle me-1"></i>
                            Untuk urusan mendesak, silakan hubungi nomor WhatsApp sekolah.
                        </p>
                        <a href="{{ $site->whatsapp_link }}" target="_blank" rel="noopener" class="btn btn-primary btn-sm w-100">
                            <i class="bi bi-whatsapp me-1"></i>Chat via WhatsApp
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
