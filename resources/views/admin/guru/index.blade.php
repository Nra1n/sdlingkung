@extends('layouts.admin')

@section('title', 'Guru & Staf')
@section('heading', 'Guru & Staf')
@section('subheading', 'Kelola data tenaga pendidik dan kependidikan')

@section('konten')
    <div class="admin-card">
        <div class="card-head">
            <h5><i class="bi bi-people me-2 text-success"></i>Daftar Guru &amp; Staf ({{ $teachers->total() }})</h5>
            <a href="{{ route('admin.guru.create') }}" class="btn btn-sm btn-primary">
                <i class="bi bi-plus-lg me-1"></i>Tambah Data
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-admin align-middle">
                <thead>
                    <tr>
                        <th style="width: 70px;">Foto</th>
                        <th>Nama</th>
                        <th>Jabatan</th>
                        <th>Mata Pelajaran / Tugas</th>
                        <th>Urutan</th>
                        <th>Status</th>
                        <th class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($teachers as $teacher)
                        <tr>
                            <td>
                                <img src="{{ $teacher->photo_url ?: asset('images/avatar.svg') }}"
                                     alt="{{ $teacher->name }}" class="table-thumb" style="width: 46px; height: 46px; border-radius: 50%;">
                            </td>
                            <td>
                                <div class="fw-semibold">{{ $teacher->name }}</div>
                                @if($teacher->nip)<div class="small text-muted">NIP. {{ $teacher->nip }}</div>@endif
                            </td>
                            <td class="small">{{ $teacher->position }}</td>
                            <td class="small text-muted">{{ $teacher->subject ?: '-' }}</td>
                            <td class="small">{{ $teacher->order }}</td>
                            <td>
                                <span class="badge-soft {{ $teacher->is_active ? 'success' : 'secondary' }}">
                                    {{ $teacher->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </td>
                            <td class="text-end text-nowrap">
                                <a href="{{ route('admin.guru.edit', $teacher) }}" class="btn btn-sm btn-outline-secondary" title="Edit">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <form action="{{ route('admin.guru.destroy', $teacher) }}" method="POST" class="d-inline"
                                      data-confirm="Hapus data {{ $teacher->name }}?">
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
                                    <i class="bi bi-person-plus"></i>
                                    Belum ada data guru. Tambahkan data tenaga pendidik terlebih dahulu.
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($teachers->hasPages())
            <div class="p-3 border-top">{{ $teachers->links() }}</div>
        @endif
    </div>
@endsection
