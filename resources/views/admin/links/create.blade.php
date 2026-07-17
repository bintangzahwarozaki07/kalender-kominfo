@extends('layouts.app')

@section('title','Tambah Link')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-success text-white">

<h4>Tambah Link Publikasi</h4>

</div>

<div class="card-body">

@if($errors->any())
<div class="alert alert-danger">
    <ul class="mb-0">
        @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

<form action="{{ route('links.store') }}" method="POST">

@csrf

<div class="mb-3">

<label>Kegiatan</label>

<select name="activity_id"
class="form-select"
required>

<option value="">Pilih Kegiatan</option>

@foreach($activities as $activity)

<option value="{{ $activity->id }}">

{{ $activity->title }}

</option>

@endforeach

</select>

</div>

<div class="mb-3">

<label>Judul</label>

<input
type="text"
name="title"
class="form-control"
placeholder="Masukkan judul publikasi..."
required>

</div>

<div class="mb-3">

<label>Platform</label>

<input
type="text"
name="platform"
class="form-control"
placeholder="Instagram, Facebook, Website, Youtube..."
required>

</div>

<div class="mb-3">

<label>URL</label>

<input
type="text"
name="url"
class="form-control"
required>

</div>

<button class="btn btn-success">

Update

</button>

<a href="{{ route('links.index') }}"
class="btn btn-secondary">

Kembali

</a>

</form>

</div>

</div>

</div>

@endsection