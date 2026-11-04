@extends('layouts.main')

@section('title', $news->title)
@section('meta_description', \Illuminate\Support\Str::limit($news->excerpt ?: strip_tags($news->content), 155))
@section('og_image', $news->image_url)

@push('styles')
    <script type="application/ld+json">
    {
        "@@context": "https://schema.org",
        "@type": "NewsArticle",
        "headline": @json($news->title),
        "image": [@json($news->image_url)],
        "datePublished": @json(($news->published_at ?? $news->created_at)->toIso8601String()),
        "dateModified": @json($news->updated_at->toIso8601String()),
        "author": {
            "@type": "Organization",
            "name": @json($site->nama_sekolah)
        },
        "publisher": {
            "@type": "Organization",
            "name": @json($site->nama_sekolah),
            "logo": {
                "@type": "ImageObject",
                "url": @json(asset('images/logo.png'))
            }
        }
    }
    </script>
@endpush

@section('konten')
    @include('partials.page-header', [
        'title' => \Illuminate\Support\Str::limit($news->title, 105),
        'subtitle' => 'Dipublikasikan ' . $news->date_label . ' oleh ' . ($news->author->name ?? $site->nama_sekolah),
        'breadcrumb' => [
            ['label' => 'Berita', 'url' => route('berita.index')],
            ['label' => \Illuminate\Support\Str::limit($news->title, 40)],
        ],
    ])

    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-9">
                    <div class="post-hero mb-4">
                        <img src="{{ $news->image_url }}" alt="{{ $news->title }}">
                    </div>

                    <div class="d-flex flex-wrap justify-content-between align-items-center gap-3 mb-4 pb-3 border-bottom">
                        <div class="news-meta mb-0">
                            <span><i class="bi bi-tag"></i>{{ $news->category }}</span>
                            <span><i class="bi bi-calendar3"></i>{{ $news->date_label }}</span>
                            <span><i class="bi bi-clock"></i>{{ $news->reading_time }} menit baca</span>
                            <span><i class="bi bi-eye"></i>{{ number_format($news->views) }} kali dibaca</span>
                        </div>
                        <div class="d-flex align-items-center gap-2">
                            <span class="small text-muted me-1">Bagikan:</span>
                            <a class="share-btn" target="_blank" rel="noopener"
                               href="https://api.whatsapp.com/send?text={{ urlencode($news->title . ' — ' . route('berita.show', $news->slug)) }}"
                               aria-label="Bagikan ke WhatsApp"><i class="bi bi-whatsapp"></i></a>
                            <a class="share-btn" target="_blank" rel="noopener"
                               href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('berita.show', $news->slug)) }}"
                               aria-label="Bagikan ke Facebook"><i class="bi bi-facebook"></i></a>
                            <a class="share-btn" target="_blank" rel="noopener"
                               href="https://twitter.com/intent/tweet?text={{ urlencode($news->title) }}&url={{ urlencode(route('berita.show', $news->slug)) }}"
                               aria-label="Bagikan ke X"><i class="bi bi-twitter-x"></i></a>
                            <button type="button" class="share-btn border-0" data-copy-link="{{ route('berita.show', $news->slug) }}"
                                    aria-label="Salin tautan"><i class="bi bi-link-45deg"></i></button>
                        </div>
                    </div>

                    @if($news->excerpt)
                        <p class="lead" style="color: #345b6d; font-size: 1.08rem; line-height: 1.8;">
                            {{ $news->excerpt }}
                        </p>
                    @endif

                    <div class="post-content">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    <div class="card-soft p-4 mt-5 d-flex flex-wrap justify-content-between align-items-center gap-3">
                        <div>
                            <div class="fw-bold">Butuh informasi lebih lanjut?</div>
                            <div class="small text-muted">Hubungi {{ $site->nama_sekolah }} pada jam kerja.</div>
                        </div>
                        <a href="{{ route('kontak') }}" class="btn btn-primary btn-sm">
                            <i class="bi bi-chat-dots me-1"></i>Hubungi Kami
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ================= BERITA TERKAIT ================= --}}
    @if($related->isNotEmpty())
        <section class="section section-tint">
            <div class="container">
                <div class="d-flex flex-wrap justify-content-between align-items-end gap-3 mb-4">
                    <div class="section-head mb-0">
                        <div class="section-eyebrow">Baca Juga</div>
                        <h2 class="section-title mb-0">Berita Terkait</h2>
                    </div>
                    <a href="{{ route('berita.index') }}" class="btn btn-outline-primary btn-sm">
                        Semua Berita <i class="bi bi-arrow-right ms-1"></i>
                    </a>
                </div>

                <div class="row g-4">
                    @foreach($related as $item)
                        <div class="col-md-6 col-lg-4">
                            @include('partials.news-card', ['item' => $item])
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('[data-copy-link]').forEach(function (button) {
            button.addEventListener('click', function () {
                const link = button.dataset.copyLink;
                if (navigator.clipboard) {
                    navigator.clipboard.writeText(link).then(function () {
                        button.innerHTML = '<i class="bi bi-check2"></i>';
                        setTimeout(function () { button.innerHTML = '<i class="bi bi-link-45deg"></i>'; }, 1600);
                    });
                }
            });
        });
    </script>
@endpush
