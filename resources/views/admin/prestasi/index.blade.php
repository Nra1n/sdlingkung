@extends('layouts.admin')

@section('title', 'Prestasi')
@section('heading', 'Kelola Prestasi')
@section('subheading', 'Catat prestasi siswa dan sekolah pada berbagai tingkat')

@section('konten')
    <div class="admin-card">
        <div class="card-head">
            <h5><i class="bi bi-trophy me-2 text-success"></i>Daftar Prestasi ({{ $achievements->total() }})</h5>
            <a href="{{ route('admin.prestasi.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Prestasi
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-admin align-middle">
                <thead>
                    <tr>
                        <th>Judul Prestasi</th>
                        <th>Tingkat</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($achievements as $achievement)
                        <tr>
                            <td>
                                <div class="fw-semibold" style="max-width: 420px;">{{ $achievement->title }}</div>
                                @if($achievement->description)
                                    <div class="small text-muted">{{ \Illuminate\Support\Str::limit($achievement->description, 80) }}</div>
                                @endif
                            </td>
                            <td><span class="badge-soft {{ $achievement->level_color }}">{{ $achievement->level }}</span></td>
                            <td class="small">{{ $achievement->year }}</td>
                            <td>
                                <span class="badge-soft {{ $achievement->is_published ? 'success' : 'secondary' }}">
                                    {{ $achievement->is_published ? 'Tayang' : 'Draf' }}
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.prestasi.edit', $achievement) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.prestasi.destroy', $achievement) }}" method="POST" class="d-inline"
                                      data-confirm="Hapus prestasi &quot;{{ $achievement->title }}&quot;?">
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
                            <td colspan="5">
                                <div class="admin-empty">
                                    <i class="bi bi-trophy"></i>
                                    Belum ada data prestasi.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($achievements->hasPages())
            <div class="p-3 border-top">{{ $achievements->links() }}</div>
        @endif
    </div>
@endsection
