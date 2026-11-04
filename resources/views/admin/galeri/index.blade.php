@extends('layouts.admin')

@section('title', 'Galeri')
@section('heading', 'Kelola Galeri')
@section('subheading', 'Atur foto dan video dokumentasi sekolah')

@section('konten')
    <div class="admin-card">
        <div class="card-head">
            <h5><i class="bi bi-images me-2 text-success"></i>Daftar Konten ({{ $galleries->total() }})</h5>
            <a href="{{ route('admin.galeri.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Konten
            </a>
        </div>

        <div class="card-body">
            @if($galleries->isEmpty())
                <div class="admin-empty">
                    <i class="bi bi-images"></i>
                    Belum ada konten galeri. Tambahkan foto atau video dokumentasi sekolah.
                </div>
            @else
                <div class="row g-3">
                    @foreach($galleries as $gallery)
                        <div class="col-6 col-md-4 col-xl-3">
                            <div class="border rounded-3 overflow-hidden h-100 d-flex flex-column">
                                @if($gallery->image)
                                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}"
                                         style="width: 100%; aspect-ratio: 4/3; object-fit: cover;">
                                @else
                                    <div class="d-flex flex-column align-items-center justify-content-center bg-light text-danger"
                                         style="width: 100%; aspect-ratio: 4/3;">
                                        <i class="bi bi-youtube fs-1"></i>
                                        <span class="small fw-semibold">Video YouTube</span>
                                    </div>
                                @endif
                                <div class="p-2 flex-grow-1">
                                    <div class="fw-semibold small" style="line-height: 1.4;">{{ $gallery->title }}</div>
                                    <div class="d-flex justify-content-between align-items-center mt-2">
                                        <span class="badge-soft info" style="font-size: .62rem;">{{ $gallery->category }}</span>
                                        <span class="badge-soft {{ $gallery->is_published ? 'success' : 'secondary' }}" style="font-size: .62rem;">
                                            {{ $gallery->is_published ? 'Tayang' : 'Draf' }}
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex border-top">
                                    <a href="{{ route('admin.galeri.edit', $gallery) }}" class="btn btn-sm btn-light flex-grow-1 rounded-0 border-end">
                                        <i class="bi bi-pencil me-1"></i>Edit
                                    </a>
                                    <form action="{{ route('admin.galeri.destroy', $gallery) }}" method="POST"
                                          data-confirm="Hapus konten &quot;{{ $gallery->title }}&quot;?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-light text-danger rounded-0">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        @if($galleries->hasPages())
            <div class="p-3 border-top">{{ $galleries->links() }}</div>
        @endif
    </div>
@endsection
