@extends('layouts.admin')

@section('title', 'Tambah Prestasi')
@section('heading', 'Tambah Prestasi')
@section('subheading', 'Catat capaian baru siswa atau sekolah')

@section('konten')
    @include('admin.prestasi._form', ['achievement' => $achievement])
@endsection
