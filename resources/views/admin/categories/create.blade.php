@extends('layouts.app')

@section('title','Tambah Kategori')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-success text-white">

Tambah Kategori

</div>

<div class="card-body">

<form action="{{ route('categories.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Nama Kategori</label>

<input
type="text"
name="name"
class="form-control"
required>

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="description"
class="form-control"
rows="4"></textarea>

</div>

<button class="btn btn-success">

Simpan

</button>

<a href="{{ route('categories.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection