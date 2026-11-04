@extends('layouts.admin')

@section('title', 'Detail Pesan')
@section('heading', 'Detail Pesan')
@section('subheading', 'Pesan dari pengunjung website')

@section('konten')
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="admin-card">
                <div class="card-head">
                    <h5>{{ $message->subject }}</h5>
                    <span class="badge-soft {{ $message->is_read ? 'secondary' : 'warning' }}">
                        {{ $message->is_read ? 'Dibaca' : 'Baru' }}
                    </span>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-wrap gap-3 pb-3 mb-3 border-bottom small text-muted">
                        <span><i class="bi bi-person me-1"></i>{{ $message->name }}</span>
                        <span><i class="bi bi-envelope me-1"></i>{{ $message->email }}</span>
                        @if($message->phone)
                            <span><i class="bi bi-telephone me-1"></i>{{ $message->phone }}</span>
                        @endif
                        <span><i class="bi bi-clock me-1"></i>{{ $message->created_at->translatedFormat('d F Y, H:i') }} WITA</span>
                    </div>

                    <div style="white-space: pre-line; line-height: 1.9; color: #345b6d;">{{ $message->message }}</div>

                    <div class="d-flex flex-wrap gap-2 mt-4 pt-3 border-top">
                        <a href="mailto:{{ $message->email }}?subject={{ urlencode('Balasan: ' . $message->subject) }}"
                           class="btn btn-primary btn-sm">
                            <i class="bi bi-reply me-1"></i>Balas via Email
                        </a>
                        @if($message->phone)
                            <a href="https://wa.me/{{ preg_replace('/\D/', '', str_starts_with(preg_replace('/\D/', '', $message->phone), '0') ? '62' . ltrim(preg_replace('/\D/', '', $message->phone), '0') : preg_replace('/\D/', '', $message->phone)) }}"
                               target="_blank" rel="noopener" class="btn btn-outline-success btn-sm">
                                <i class="bi bi-whatsapp me-1"></i>Balas via WhatsApp
                            </a>
                        @endif
                        <a href="{{ route('admin.pesan.index') }}" class="btn btn-outline-secondary btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Kembali
                        </a>
                        <form action="{{ route('admin.pesan.destroy', $message) }}" method="POST" class="ms-auto"
                              data-confirm="Hapus pesan ini?">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger btn-sm">
                                <i class="bi bi-trash me-1"></i>Hapus Pesan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="admin-card">
                <div class="card-head"><h5>Informasi Pengirim</h5></div>
                <div class="card-body">
                    <div class="small mb-3">
                        <div class="text-muted mb-1">Nama</div>
                        <div class="fw-semibold">{{ $message->name }}</div>
                    </div>
                    <div class="small mb-3">
                        <div class="text-muted mb-1">Email</div>
                        <a href="mailto:{{ $message->email }}">{{ $message->email }}</a>
                    </div>
                    <div class="small mb-3">
                        <div class="text-muted mb-1">Telepon / WhatsApp</div>
                        <div>{{ $message->phone ?: '-' }}</div>
                    </div>
                    <div class="small mb-0">
                        <div class="text-muted mb-1">Diterima</div>
                        <div>{{ $message->created_at->translatedFormat('d F Y, H:i') }} WITA</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
