@extends('layouts.admin')

@section('title', 'Berita')
@section('heading', 'Kelola Berita')
@section('subheading', 'Tulis, edit, dan atur publikasi berita sekolah')

@section('konten')
    <div class="admin-card">
        <div class="card-head flex-wrap">
            <form action="{{ route('admin.berita.index') }}" method="GET" class="d-flex gap-2" style="max-width: 360px;">
                <input type="search" name="q" class="form-control form-control-sm" value="{{ $search }}"
                       placeholder="Cari judul berita...">
                <button class="btn btn-sm btn-outline-secondary" type="submit"><i class="bi bi-search"></i></button>
            </form>
            <a href="{{ route('admin.berita.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Berita
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-admin align-middle">
                <thead>
                    <tr>
                        <th style="width: 80px;">Gambar</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Tanggal</th>
                        <th>Dibaca</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($news as $item)
                        <tr>
                            <td>
                                <img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="table-thumb">
                            </td>
                            <td>
                                <div class="fw-semibold" style="max-width: 340px;">{{ $item->title }}</div>
                                <div class="small text-muted">/berita/{{ $item->slug }}</div>
                            </td>
                            <td><span class="badge-soft info">{{ $item->category }}</span></td>
                            <td>
                                <span class="badge-soft {{ $item->is_published ? 'success' : 'secondary' }}">
                                    {{ $item->is_published ? 'Tayang' : 'Draf' }}
                                </span>
                            </td>
                            <td class="small text-muted text-nowrap">
                                {{ ($item->published_at ?? $item->created_at)?->format('d/m/Y') }}
                            </td>
                            <td class="small">{{ number_format($item->views) }}</td>
                            <td class="text-end text-nowrap">
                                @if($item->is_published)
                                    <a href="{{ route('berita.show', $item->slug) }}" target="_blank" rel="noopener"
                                       class="btn btn-sm btn-outline-secondary" title="Lihat di website">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                @endif
                                <a href="{{ route('admin.berita.edit', $item) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.berita.destroy', $item) }}" method="POST" class="d-inline"
                                      data-confirm="Hapus berita &quot;{{ $item->title }}&quot;? Tindakan ini tidak dapat dibatalkan.">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="admin-empty">
                                    <i class="bi bi-newspaper"></i>
                                    {{ $search ? 'Berita dengan kata kunci tersebut tidak ditemukan.' : 'Belum ada berita. Mulai dengan menulis berita pertama.' }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($news->hasPages())
            <div class="p-3 border-top">{{ $news->links() }}</div>
        @endif
    </div>
@endsection
