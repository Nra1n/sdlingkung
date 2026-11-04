@extends('layouts.admin')

@section('title', 'Tambah Guru')
@section('heading', 'Tambah Guru / Staf')
@section('subheading', 'Masukkan data tenaga pendidik atau kependidikan')

@section('konten')
    @include('admin.guru._form', ['teacher' => $teacher])
@endsection
