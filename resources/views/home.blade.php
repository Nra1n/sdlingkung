@extends('layouts.main')

@section('title', 'Beranda')
@section('meta_description', $site->tagline)

@section('konten')
    {{-- ================= HERO ================= --}}
    <section class="hero" @if($site->hero_image) style="--hero-image: url('{{ \App\Support\Media::url($site->hero_image) }}')" @endif>
        <div class="container position-relative" style="z-index: 2;">
            <div class="row align-items-center g-5">
                <div class="col-lg-7">
                    <span class="hero-badge">
                        <span class="dot"></span>
                        Akreditasi {{ $site->akreditasi ?? 'A' }} &middot;
                    </span>
                    <h1>
                        SD NEGERI LINGKUNG<br>
                        <span class="highlight">{{ $site->tagline ?: 'Membentuk Generasi Cerdas' }}</span>
                    </h1>
                    <div class="hero-actions">
                        <a href="{{ route('profil') }}" class="btn btn-accent btn-lg">
                            <i class="bi bi-building me-2"></i>Kenali Sekolah Kami
                        </a>
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-newspaper me-2"></i>Lihat Berita
                        </a>
                    </div>
                    <div class="hero-note">
                        <span class="line"></span>
                        <span>Dipercaya masyarakat sejak tahun {{ $site->tahun_berdiri ?? '1985' }}</span>
                    </div>
                </div>

                <div class="col-lg-5 d-none d-lg-block">
                    <div class="hero-card">
                        <div class="d-flex justify-content-between align-items-start">
                            <div>
                                <div class="label">Penerimaan Siswa Baru</div>
                                <div class="value">2026 / 2027</div>
                                <div class="sub">Pendaftaran dibuka &middot; kuota terbatas</div>
                            </div>
                            <i class="bi bi-megaphone" style="font-size: 2rem; color: #fbbf24;"></i>
                        </div>
                        <a href="{{ route('kontak', ['topik' => 'Pendaftaran Siswa Baru (PPDB)']) }}" class="btn btn-light btn-sm w-100 mt-3 fw-bold text-success">
                            Tanya Pendaftaran <i class="bi bi-arrow-right ms-1"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= SAMBUTAN ================= --}}
    <section class="section">
        <div class="container">
            <div class="row align-items-center g-5">
                <div class="col-lg-4">
                    <div class="photo-frame">
                        @if($site->foto_kepala_sekolah)
                            <img src="{{ \App\Support\Media::url($site->foto_kepala_sekolah) }}"
                                 alt="Kepala {{ $site->nama_sekolah }}" class="headmaster-photo">
                        @else
                            <div class="headmaster-photo d-flex align-items-center justify-content-center"
                                 style="background: linear-gradient(135deg, #0ea5e9, #075985);">
                                <i class="bi bi-person-fill" style="font-size: 7rem; color: rgba(255,255,255,.85);"></i>
                            </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="section-eyebrow">Sambutan Kepala Sekolah</div>
                    <div class="card-soft quote-card reveal">
                        <p>{{ \Illuminate\Support\Str::limit($site->sambutan, 620) }}</p>
                        <div class="d-flex align-items-center gap-3 mt-4">
                            <div class="teacher-initials" style="width: 52px; height: 52px; font-size: 1rem; margin: 0;">
                                {{ \Illuminate\Support\Str::upper(mb_substr($site->kepala_sekolah ?? 'K', 0, 1)) }}
                            </div>
                            <div>
                                <div class="fw-bold">{{ $site->kepala_sekolah }}</div>
                                <div class="small text-muted">Kepala {{ $site->nama_sekolah }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

        {{-- ================= GURU ================= --}}
    <section class="section">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                <div class="section-head mb-0">
                    <div class="section-eyebrow">Tenaga Pendidik</div>
                    <h2 class="section-title mb-0">Guru &amp; Staf Sekolah</h2>
                </div>
                <a href="{{ route('profil') }}#guru" class="btn btn-outline-primary btn-sm">
                    Lihat Semua <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-4">
                @foreach($teachers as $teacher)
                    <div class="col-6 col-lg-3">
                        <div class="reveal h-100">@include('partials.teacher-card', ['teacher' => $teacher])</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    {{-- ================= PRESTASI ================= --}}
    <section class="section section-tint" id="prestasi">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-5">
                    <div class="section-eyebrow">Prestasi Siswa</div>
                    <h2 class="section-title">Kebanggaan yang Terus Bertumbuh</h2>
                    <p class="section-lead">
                        Berbagai capaian akademik dan nonakademik menjadi bukti komitmen kami
                        dalam mendampingi setiap potensi siswa.
                    </p>
                    <a href="{{ route('profil') }}#prestasi" class="btn btn-primary mt-3">
                        Lihat Semua Prestasi <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>
                <div class="col-lg-7">
                    <div class="d-grid gap-3">
                        @forelse($achievements as $achievement)
                            <div class="achievement-item reveal">
                                <span class="achievement-medal"><i class="bi bi-trophy-fill"></i></span>
                                <div class="flex-grow-1">
                                    <h6>{{ $achievement->title }}</h6>
                                    <div class="meta">
                                        <span class="badge-soft {{ $achievement->level_color }} me-2">{{ $achievement->level }}</span>
                                        Tahun {{ $achievement->year }}
                                    </div>
                                </div>
                                <i class="bi bi-chevron-right text-muted"></i>
                            </div>
                        @empty
                            <div class="card-soft p-4 text-center text-muted">Belum ada data prestasi.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= BERITA ================= --}}
    <section class="section">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                <div class="section-head mb-0">
                    <div class="section-eyebrow">Informasi Terbaru</div>
                    <h2 class="section-title mb-0">Berita &amp; Kegiatan Sekolah</h2>
                </div>
                <a href="{{ route('berita.index') }}" class="btn btn-outline-primary btn-sm">
                    Semua Berita <i class="bi bi-arrow-right ms-1"></i>
                </a>
            </div>

            <div class="row g-4">
                @forelse($latestNews as $item)
                    <div class="col-md-6 col-lg-4">
                        <div class="reveal h-100">@include('partials.news-card', ['item' => $item])</div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="card-soft p-5 text-center text-muted">
                            <i class="bi bi-newspaper fs-1 d-block mb-2" style="color: var(--brand-200);"></i>
                            Belum ada berita yang diterbitkan.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= CTA ================= --}}
    <section class="section">
        <div class="container">
            <div class="cta-band">
                <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <h2>Siap Bergabung Bersama Kami?</h2>
                        <p>
                            Pendaftaran peserta didik baru tahun ajaran 2026/2027 telah dibuka.
                            Hubungi kami untuk informasi syarat, jadwal, dan alur pendaftaran.
                        </p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('kontak', ['topik' => 'Pendaftaran Siswa Baru (PPDB)']) }}" class="btn btn-accent btn-lg">
                            <i class="bi bi-whatsapp me-2"></i>Tanya PPDB
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.gallery-modal')
@endsection
