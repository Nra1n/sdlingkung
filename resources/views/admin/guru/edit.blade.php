@extends('layouts.admin')

@section('title', 'Edit Guru')
@section('heading', 'Edit Guru / Staf')
@section('subheading', 'Perbarui data tenaga pendidik atau kependidikan')

@section('konten')
    @include('admin.guru._form', ['teacher' => $teacher])
@endsection
