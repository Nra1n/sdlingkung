<article class="gallery-video card-soft overflow-hidden h-100">
    <div class="ratio ratio-16x9 bg-dark">
        <button type="button" class="gallery-video-preview"
                data-video-embed="{{ $gallery->youtube_embed_url }}"
                data-video-origin="{{ request()->getSchemeAndHttpHost() }}"
                data-video-title="{{ $gallery->title }}"
                aria-label="Putar video: {{ $gallery->title }}">
            <img src="{{ $gallery->youtube_thumbnail_url }}" alt="" loading="lazy">
            <span class="gallery-video-play" aria-hidden="true"><i class="bi bi-play-fill"></i></span>
        </button>
    </div>
    <div class="p-3">
        <h3 class="h6 mb-1">{{ $gallery->title }}</h3>
        <div class="small text-muted">{{ $gallery->category }}</div>
        @if($gallery->description)
            <p class="small text-muted mt-2 mb-0">{{ $gallery->description }}</p>
        @endif
    </div>
</article>
