@extends('layouts.main')

@section('title', 'Halaman Tidak Ditemukan')
@section('meta_description', 'Halaman yang Anda cari tidak tersedia.')

@section('konten')
    <section class="section">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-7 text-center py-5">
                    <div class="display-1 fw-bold" style="color: var(--brand-200); line-height: 1;">404</div>
                    <h1 class="section-title mt-3">Halaman Tidak Ditemukan</h1>
                    <p class="section-lead mx-auto mb-4">
                        Maaf, halaman yang Anda cari mungkin sudah dipindahkan atau tidak tersedia lagi.
                    </p>
                    <div class="d-flex flex-wrap justify-content-center gap-2">
                        <a href="{{ route('home') }}" class="btn btn-primary">
                            <i class="bi bi-house me-2"></i>Kembali ke Beranda
                        </a>
                        <a href="{{ route('berita.index') }}" class="btn btn-outline-primary">
                            <i class="bi bi-newspaper me-2"></i>Lihat Berita
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
