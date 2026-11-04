@extends('layouts.admin')

@section('title', 'Pesan Masuk')
@section('heading', 'Pesan Masuk')
@section('subheading', 'Pesan dan pertanyaan dari pengunjung website')

@section('konten')
    <div class="admin-card">
        <div class="card-head flex-wrap">
            <div class="d-flex gap-2">
                <a href="{{ route('admin.pesan.index') }}"
                   class="filter-pill {{ $filter !== 'baru' ? 'active' : '' }}">Semua</a>
                <a href="{{ route('admin.pesan.index', ['filter' => 'baru']) }}"
                   class="filter-pill {{ $filter === 'baru' ? 'active' : '' }}">
                    Belum Dibaca @if($unreadCount > 0)<span class="badge-soft danger ms-1">{{ $unreadCount }}</span>@endif
                </a>
            </div>
            <span class="small text-muted">{{ $messages->total() }} pesan</span>
        </div>

        <div class="table-responsive">
            <table class="table table-admin align-middle">
                <thead>
                    <tr>
                        <th>Pengirim</th>
                        <th>Subjek</th>
                        <th>Kontak</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($messages as $message)
                        <tr style="{{ $message->is_read ? '' : 'background: #fffbeb;' }}">
                            <td>
                                <a href="{{ route('admin.pesan.show', $message) }}" class="fw-semibold text-decoration-none" style="color: var(--ink);">
                                    {{ $message->name }}
                                </a>
                            </td>
                            <td class="small">{{ \Illuminate\Support\Str::limit($message->subject, 50) }}</td>
                            <td class="small text-muted">
                                <div>{{ $message->email }}</div>
                                @if($message->phone)<div>{{ $message->phone }}</div>@endif
                            </td>
                            <td class="small text-muted text-nowrap">{{ $message->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <span class="badge-soft {{ $message->is_read ? 'secondary' : 'warning' }}">
                                    {{ $message->is_read ? 'Dibaca' : 'Baru' }}
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.pesan.show', $message) }}" class="btn btn-sm btn-outline-secondary" title="Buka">
                                    <i class="bi bi-envelope-open"></i>
                                </a>
                                <form action="{{ route('admin.pesan.destroy', $message) }}" method="POST" class="d-inline"
                                      data-confirm="Hapus pesan dari {{ $message->name }}?">
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
                            <td colspan="6">
                                <div class="admin-empty">
                                    <i class="bi bi-inbox"></i>
                                    {{ $filter === 'baru' ? 'Tidak ada pesan yang belum dibaca.' : 'Belum ada pesan masuk.' }}
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="p-3 border-top">{{ $messages->links() }}</div>
        @endif
    </div>
@endsection
