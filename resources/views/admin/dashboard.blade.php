@extends('layouts.admin')

@section('title', 'Dashboard')
@section('heading', 'Dashboard')
@section('subheading', 'Ringkasan konten dan aktivitas website sekolah')

@section('konten')
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="admin-stat">
                <div class="icon" style="background: #c2f6ff; color: #0a7d99;"><i class="bi bi-newspaper"></i></div>
                <div class="value">{{ number_format($stats['berita']) }}</div>
                <div class="label">Total Berita &middot; {{ $stats['berita_tayang'] }} tayang</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="admin-stat">
                <div class="icon" style="background: #dbeafe; color: #1e40af;"><i class="bi bi-people"></i></div>
                <div class="value">{{ number_format($stats['guru']) }}</div>
                <div class="label">Guru &amp; Staf Aktif</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="admin-stat">
                <div class="icon" style="background: #fef3c7; color: #92400e;"><i class="bi bi-images"></i></div>
                <div class="value">{{ number_format($stats['galeri']) }}</div>
                <div class="label">Konten Galeri</div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="admin-stat">
                <div class="icon" style="background: #fee2e2; color: #991b1b;"><i class="bi bi-envelope"></i></div>
                <div class="value">{{ number_format($stats['pesan_baru']) }}</div>
                <div class="label">Pesan Belum Dibaca</div>
            </div>
        </div>
    </div>

    <div class="row g-4">
        <div class="col-lg-7">
            <div class="admin-card h-100">
                <div class="card-head">
                    <h5><i class="bi bi-clock-history me-2 text-success"></i>Berita Terbaru</h5>
                    <a href="{{ route('admin.berita.index') }}" class="btn btn-sm btn-outline-secondary">Kelola</a>
                </div>
                <div class="table-responsive">
                    <table class="table table-admin align-middle">
                        <thead>
                            <tr>
                                <th>Judul</th>
                                <th>Status</th>
                                <th>Tanggal</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($latestNews as $item)
                                <tr>
                                    <td>
                                        <div class="fw-semibold" style="max-width: 280px;">{{ \Illuminate\Support\Str::limit($item->title, 55) }}</div>
                                        <div class="small text-muted">{{ $item->category }}</div>
                                    </td>
                                    <td>
                                        <span class="badge-soft {{ $item->is_published ? 'success' : 'secondary' }}">
                                            {{ $item->is_published ? 'Tayang' : 'Draf' }}
                                        </span>
                                    </td>
                                    <td class="small text-muted text-nowrap">{{ ($item->published_at ?? $item->created_at)?->format('d/m/Y') }}</td>
                                    <td class="text-end">
                                        <a href="{{ route('admin.berita.edit', $item) }}" class="btn btn-sm btn-outline-secondary">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="4" class="text-center text-muted py-4">Belum ada berita.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-lg-5">
            <div class="admin-card h-100">
                <div class="card-head">
                    <h5><i class="bi bi-inbox me-2 text-warning"></i>Pesan Terbaru</h5>
                    <a href="{{ route('admin.pesan.index') }}" class="btn btn-sm btn-outline-secondary">Semua</a>
                </div>
                <div class="card-body p-0">
                    @forelse($latestMessages as $message)
                        <a href="{{ route('admin.pesan.show', $message) }}" class="d-block p-3 text-decoration-none border-bottom">
                            <div class="d-flex justify-content-between align-items-start gap-2">
                                <div>
                                    <div class="fw-semibold small" style="color: var(--ink);">{{ $message->name }}</div>
                                    <div class="small text-muted">{{ \Illuminate\Support\Str::limit($message->subject, 42) }}</div>
                                </div>
                                @if(! $message->is_read)
                                    <span class="badge-soft warning">Baru</span>
                                @endif
                            </div>
                            <div class="small text-muted mt-1" style="font-size: .72rem;">
                                {{ $message->created_at->diffForHumans() }}
                            </div>
                        </a>
                    @empty
                        <div class="p-4 text-center text-muted small">Belum ada pesan masuk.</div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

@endsection
