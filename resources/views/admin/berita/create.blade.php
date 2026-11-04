@extends('layouts.admin')

@section('title', 'Tambah Berita')
@section('heading', 'Tambah Berita')
@section('subheading', 'Tulis berita atau pengumuman baru')

@section('konten')
    @include('admin.berita._form', ['news' => $news])
@endsection
