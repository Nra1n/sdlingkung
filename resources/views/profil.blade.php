@extends('layouts.main')

@section('title', 'Profil Sekolah')
@section('meta_description', 'Profil, sejarah, visi misi, guru, dan prestasi ' . $site->nama_sekolah)

@section('konten')
    @include('partials.page-header', [
        'title' => 'Profil Sekolah',
        'subtitle' => 'Mengenal lebih dekat ' . $site->nama_sekolah . ' — sejarah, visi misi, tenaga pendidik, dan prestasi.',
        'breadcrumb' => [['label' => 'Profil']],
    ])

    {{-- ================= TENTANG & SEJARAH ================= --}}
    <section class="section">
        <div class="container">
            <div class="row g-5 align-items-center">
                <div class="col-lg-6">
                    <div class="section-eyebrow">Tentang Kami</div>
                    <h2 class="section-title">Sekolah yang Tumbuh Bersama Masyarakat</h2>
                    <div class="post-content" style="font-size: .96rem;">
                        {!! nl2br(e($site->sejarah)) !!}
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="row g-3">
                        <div class="col-6">
                            <div class="card-soft p-4 text-center h-100">
                                <div class="stat-number" style="color: var(--brand-800);">{{ number_format($site->jumlah_siswa) }}</div>
                                <div class="small text-muted mt-2">Peserta Didik</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-soft p-4 text-center h-100">
                                <div class="stat-number" style="color: var(--brand-800);">{{ number_format($site->jumlah_guru) }}</div>
                                <div class="small text-muted mt-2">Guru &amp; Tenaga Kependidikan</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-soft p-4 text-center h-100">
                                <div class="stat-number" style="color: var(--brand-800);">{{ $site->jumlah_kelas }}</div>
                                <div class="small text-muted mt-2">Rombongan Belajar</div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="card-soft p-4 text-center h-100">
                                <div class="stat-number" style="color: var(--brand-800);">{{ $site->akreditasi ?? '-' }}</div>
                                <div class="small text-muted mt-2">Akreditasi Sekolah</div>
                            </div>
                        </div>
                    </div>
                    <div class="alert alert-light border mt-3 mb-0 small">
                        <i class="bi bi-geo-alt-fill me-2 text-success"></i>{{ $site->alamat }}
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= VISI & MISI ================= --}}
    <section class="section section-tint" id="visi-misi">
        <div class="container">
            <div class="section-head center">
                <div class="section-eyebrow">Arah Pendidikan</div>
                <h2 class="section-title">Visi &amp; Misi Sekolah</h2>
                <p class="section-lead">Landasan kami dalam menyelenggarakan pendidikan dasar yang bermutu.</p>
            </div>

            <div class="row g-4">
                <div class="col-lg-5">
                    <div class="card-soft p-4 p-lg-5 h-100 reveal">
                        <span class="icon-box mb-3"><i class="bi bi-eye"></i></span>
                        <h4 class="mb-3">Visi</h4>
                        <p class="text-muted mb-0" style="line-height: 1.85;">{{ $site->visi }}</p>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="card-soft p-4 p-lg-5 h-100 reveal">
                        <span class="icon-box accent mb-3"><i class="bi bi-list-check"></i></span>
                        <h4 class="mb-3">Misi</h4>
                        @php
                            $misiItems = array_filter(preg_split('/\r\n|\r|\n/', (string) $site->misi));
                        @endphp
                        <ol class="mb-0 ps-3" style="line-height: 1.9;">
                            @foreach($misiItems as $misi)
                                <li class="mb-2">{{ $misi }}</li>
                            @endforeach
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= GURU & STAF ================= --}}
    <section class="section section-tint" id="guru">
        <div class="container">
            <div class="section-head center">
                <div class="section-eyebrow">Tenaga Pendidik</div>
                <h2 class="section-title">Guru &amp; Staf {{ $site->nama_sekolah }}</h2>
                <p class="section-lead">Didukung pendidik profesional dan berdedikasi untuk mendampingi setiap siswa.</p>
            </div>

            <div class="row g-4">
                @forelse($teachers as $teacher)
                    <div class="col-6 col-md-4 col-lg-3">
                        <div class="reveal h-100">@include('partials.teacher-card', ['teacher' => $teacher])</div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">Belum ada data guru.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= PRESTASI ================= --}}
    <section class="section" id="prestasi">
        <div class="container">
            <div class="section-head center">
                <div class="section-eyebrow">Capaian Sekolah</div>
                <h2 class="section-title">Prestasi Siswa &amp; Sekolah</h2>
                <p class="section-lead">Daftar prestasi yang telah diraih pada berbagai tingkat kompetisi.</p>
            </div>

            <div class="row g-4">
                @forelse($achievements as $achievement)
                    <div class="col-md-6 col-lg-4">
                        <div class="card-soft p-4 h-100 reveal">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <span class="achievement-medal"><i class="bi bi-trophy-fill"></i></span>
                                <span class="badge-soft {{ $achievement->level_color }}">{{ $achievement->level }}</span>
                            </div>
                            <h5 class="mb-2" style="font-size: 1rem;">{{ $achievement->title }}</h5>
                            <p class="small text-muted mb-2" style="line-height: 1.7;">{{ $achievement->description }}</p>
                            <div class="small fw-bold" style="color: var(--brand-700);">Tahun {{ $achievement->year }}</div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center text-muted">Belum ada data prestasi.</div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ================= CTA ================= --}}
    <section class="section-sm">
        <div class="container">
            <div class="cta-band">
                <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <h2>Ingin tahu lebih banyak?</h2>
                        <p>Kami terbuka untuk pertanyaan seputar program sekolah, PPDB, maupun kerja sama.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('kontak') }}" class="btn btn-accent btn-lg">
                            <i class="bi bi-chat-dots me-2"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
