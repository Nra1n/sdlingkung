<article class="card-soft news-card">
    <a href="{{ route('berita.show', $item->slug) }}" class="news-thumb d-block">
        <img src="{{ $item->image_url }}" alt="{{ $item->title }}" loading="lazy">
        <span class="badge-category">{{ $item->category }}</span>
    </a>
    <div class="news-body">
        <div class="news-meta">
            <span><i class="bi bi-calendar3"></i>{{ $item->date_label }}</span>
            <span><i class="bi bi-clock"></i>{{ $item->reading_time }} menit baca</span>
        </div>
        <h3 class="news-title">
            <a href="{{ route('berita.show', $item->slug) }}">{{ $item->title }}</a>
        </h3>
        <p class="news-excerpt">{{ \Illuminate\Support\Str::limit($item->excerpt ?: strip_tags($item->content), 120) }}</p>
        <a href="{{ route('berita.show', $item->slug) }}" class="news-link">
            Baca selengkapnya <i class="bi bi-arrow-right"></i>
        </a>
    </div>
</article>
