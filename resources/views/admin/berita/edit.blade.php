@extends('layouts.admin')

@section('title', 'Edit Berita')
@section('heading', 'Edit Berita')
@section('subheading', 'Perbarui isi dan pengaturan publikasi berita')

@section('konten')
    @include('admin.berita._form', ['news' => $news])
@endsection
