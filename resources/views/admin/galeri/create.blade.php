@extends('layouts.admin')

@section('title', 'Tambah Konten Galeri')
@section('heading', 'Tambah Konten Galeri')
@section('subheading', 'Tambahkan foto atau video dokumentasi sekolah')

@section('konten')
    @include('admin.galeri._form', ['gallery' => $gallery])
@endsection
