@extends('layouts.admin')

@section('title', 'Edit Prestasi')
@section('heading', 'Edit Prestasi')
@section('subheading', 'Perbarui data prestasi')

@section('konten')
    @include('admin.prestasi._form', ['achievement' => $achievement])
@endsection
