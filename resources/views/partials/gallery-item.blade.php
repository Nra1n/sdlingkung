<button type="button" class="gallery-item border-0 p-0 w-100 text-start"
        data-bs-toggle="modal" data-bs-target="#galleryModal"
        data-src="{{ $gallery->image_url }}"
        data-title="{{ $gallery->title }}"
        data-desc="{{ $gallery->description }}">
    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" loading="lazy">
    <span class="zoom"><i class="bi bi-arrows-fullscreen"></i></span>
    <span class="gallery-caption">
        <h6>{{ $gallery->title }}</h6>
        <small>{{ $gallery->category }}</small>
    </span>
</button>
