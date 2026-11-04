@extends('layouts.main')

@section('title', 'Galeri Sekolah')
@section('meta_description', 'Dokumentasi kegiatan, fasilitas, dan momen pembelajaran di ' . $site->nama_sekolah)

@section('konten')
    @include('partials.page-header', [
        'title' => 'Galeri Sekolah',
        'subtitle' => 'Dokumentasi kegiatan belajar, fasilitas, dan momen kebersamaan warga sekolah.',
        'breadcrumb' => [['label' => 'Galeri']],
    ])

    <section class="section">
        <div class="container">
            <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4">
                <div class="d-flex flex-wrap gap-2">
                    <a href="{{ route('galeri') }}" class="filter-pill {{ $category === '' ? 'active' : '' }}">Semua</a>
                    @foreach($categories as $cat)
                        <a href="{{ route('galeri', ['kategori' => $cat->category]) }}"
                           class="filter-pill {{ $category === $cat->category ? 'active' : '' }}">
                            {{ $cat->category }} <span class="opacity-75">({{ $cat->total }})</span>
                        </a>
                    @endforeach
                </div>
                <span class="small text-muted">{{ $photos->total() }} foto &middot; {{ $videos->total() }} video</span>
            </div>

            @if($photos->isEmpty() && $videos->isEmpty())
                <div class="card-soft p-5 text-center text-muted">
                    <i class="bi bi-images fs-1 d-block mb-2" style="color: var(--brand-200);"></i>
                    Belum ada konten pada kategori ini.
                </div>
            @else
                @if($photos->isNotEmpty())
                    <section aria-labelledby="galleryPhotosTitle">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <h2 id="galleryPhotosTitle" class="section-title h3 mb-0">Foto</h2>
                            <div class="flex-grow-1 border-top"></div>
                            <span class="small text-muted">{{ $photos->total() }} foto</span>
                        </div>
                        <div class="gallery-grid">
                            @foreach($photos as $gallery)
                                <div class="reveal">@include('partials.gallery-item', ['gallery' => $gallery])</div>
                            @endforeach
                        </div>

                        @if($photos->hasPages())
                            <div class="mt-4">{{ $photos->links() }}</div>
                        @endif
                    </section>
                @endif

                @if($videos->isNotEmpty())
                    <section class="mt-5 pt-4 border-top" aria-labelledby="galleryVideosTitle">
                        <div class="d-flex align-items-center gap-3 mb-4">
                            <h2 id="galleryVideosTitle" class="section-title h3 mb-0">Video</h2>
                            <div class="flex-grow-1 border-top"></div>
                            <span class="small text-muted">{{ $videos->total() }} video</span>
                        </div>
                        <div class="gallery-grid">
                            @foreach($videos as $gallery)
                                <div class="reveal">@include('partials.gallery-video', ['gallery' => $gallery])</div>
                            @endforeach
                        </div>

                        @if($videos->hasPages())
                            <div class="mt-4">{{ $videos->links() }}</div>
                        @endif
                    </section>
                @endif
            @endif
        </div>
    </section>

    <section class="section-sm pb-5">
        <div class="container">
            <div class="cta-band">
                <div class="row align-items-center g-4 position-relative" style="z-index: 2;">
                    <div class="col-lg-8">
                        <h2>Ingin melihat langsung suasana sekolah?</h2>
                        <p>Silakan berkunjung pada hari dan jam kerja. Kami akan dengan senang hati menyambut Anda.</p>
                    </div>
                    <div class="col-lg-4 text-lg-end">
                        <a href="{{ route('kontak') }}" class="btn btn-accent btn-lg">
                            <i class="bi bi-geo-alt me-2"></i>Lokasi &amp; Kontak
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @include('partials.gallery-modal')
@endsection
