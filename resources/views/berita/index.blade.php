@extends('layouts.main')

@section('title', 'Berita Sekolah')
@section('meta_description', 'Berita, pengumuman, dan kegiatan terbaru ' . $site->nama_sekolah)

@section('konten')
    @include('partials.page-header', [
        'title' => 'Berita & Kegiatan',
        'subtitle' => 'Informasi terbaru seputar kegiatan belajar, prestasi, pengumuman, dan agenda sekolah.',
        'breadcrumb' => [['label' => 'Berita']],
    ])

    <section class="section">
        <div class="container">
            <div class="row g-4 g-lg-5">
                <div class="col-lg-8">
                    {{-- Pencarian & filter kategori --}}
                    <form action="{{ route('berita.index') }}" method="GET" class="mb-4">
                        <div class="input-group">
                            <input type="search" name="q" class="form-control" value="{{ $search }}"
                                   placeholder="Cari berita atau pengumuman..." aria-label="Cari berita">
                            <button class="btn btn-primary px-4" type="submit">
                                <i class="bi bi-search"></i>
                            </button>
                        </div>
                        @if($category)
                            <input type="hidden" name="kategori" value="{{ $category }}">
                        @endif
                    </form>

                    <div class="d-flex flex-wrap gap-2 mb-4">
                        <a href="{{ route('berita.index', array_filter(['q' => $search])) }}"
                           class="filter-pill {{ $category === '' ? 'active' : '' }}">Semua</a>
                        @foreach($categories as $cat)
                            <a href="{{ route('berita.index', array_filter(['q' => $search, 'kategori' => $cat->category])) }}"
                               class="filter-pill {{ $category === $cat->category ? 'active' : '' }}">
                                {{ $cat->category }} <span class="opacity-75">({{ $cat->total }})</span>
                            </a>
                        @endforeach
                    </div>

                    @if($search || $category)
                        <p class="small text-muted mb-3">
                            Menampilkan {{ $news->total() }} hasil
                            @if($search) untuk pencarian "<strong>{{ $search }}</strong>"@endif
                            @if($category) pada kategori <strong>{{ $category }}</strong>@endif
                            &middot; <a href="{{ route('berita.index') }}">Reset filter</a>
                        </p>
                    @endif

                    <div class="row g-4">
                        @forelse($news as $item)
                            <div class="col-md-6">
                                @include('partials.news-card', ['item' => $item])
                            </div>
                        @empty
                            <div class="col-12">
                                <div class="card-soft p-5 text-center">
                                    <i class="bi bi-search fs-1 d-block mb-2" style="color: var(--brand-200);"></i>
                                    <h5 class="mb-1">Berita tidak ditemukan</h5>
                                    <p class="text-muted mb-3">Coba gunakan kata kunci lain atau lihat semua berita.</p>
                                    <a href="{{ route('berita.index') }}" class="btn btn-outline-primary btn-sm">Lihat Semua Berita</a>
                                </div>
                            </div>
                        @endforelse
                    </div>

                    <div class="mt-4">
                        {{ $news->links() }}
                    </div>
                </div>

                {{-- Sidebar --}}
                <aside class="col-lg-4">
                    <div class="sidebar-card mb-4">
                        <h6><i class="bi bi-fire me-1 text-warning"></i>Paling Dibaca</h6>
                        <div class="d-grid gap-3">
                            @forelse($popular as $index => $pop)
                                <a href="{{ route('berita.show', $pop->slug) }}" class="d-flex gap-3 text-decoration-none">
                                    <span class="fw-bold" style="color: var(--brand-300); font-size: 1.1rem;">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                    <span>
                                        <span class="d-block fw-semibold" style="font-size: .85rem; color: var(--ink); line-height: 1.5;">{{ $pop->title }}</span>
                                        <span class="small text-muted">{{ $pop->date_label }}</span>
                                    </span>
                                </a>
                            @empty
                                <span class="small text-muted">Belum ada berita.</span>
                            @endforelse
                        </div>
                    </div>

                    <div class="sidebar-card mb-4">
                        <h6>Kategori</h6>
                        <div class="sidebar-list">
                            @foreach($categories as $cat)
                                <a href="{{ route('berita.index', ['kategori' => $cat->category]) }}">
                                    <span>{{ $cat->category }}</span>
                                    <span class="count">{{ $cat->total }}</span>
                                </a>
                            @endforeach
                        </div>
                    </div>

                    <div class="card-soft p-4" style="background: linear-gradient(135deg, #027cb8, #075985); border: 0;">
                        <h5 class="text-white mb-2" style="font-size: 1.05rem;">Punya pertanyaan?</h5>
                        <p class="small mb-3" style="color: #c9edf8;">Tim sekolah siap membantu Anda pada jam kerja.</p>
                        <a href="{{ route('kontak') }}" class="btn btn-accent btn-sm w-100">Hubungi Sekolah</a>
                    </div>
                </aside>
            </div>
        </div>
    </section>
@endsection
