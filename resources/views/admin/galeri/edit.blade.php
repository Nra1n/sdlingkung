@extends('layouts.admin')

@section('title', 'Edit Konten Galeri')
@section('heading', 'Edit Konten Galeri')
@section('subheading', 'Perbarui keterangan atau ubah foto dan video')

@section('konten')
    @include('admin.galeri._form', ['gallery' => $gallery])
@endsection
