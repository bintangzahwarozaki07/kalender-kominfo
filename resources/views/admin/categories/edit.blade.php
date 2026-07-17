@extends('layouts.app')

@section('title','Edit Kategori')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-warning">

Edit Kategori

</div>

<div class="card-body">

<form
action="{{ route('categories.update',$category) }}"
method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Nama</label>

<input
type="text"
name="name"
class="form-control"
value="{{ old('name',$category->name) }}"
required>

</div>

<div class="mb-3">

<label>Deskripsi</label>

<textarea
name="description"
class="form-control"
rows="4">{{ old('description',$category->description) }}</textarea>

</div>

<button class="btn btn-primary">

Update

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