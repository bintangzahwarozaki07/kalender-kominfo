@extends('layouts.app')

@section('title','Edit Link')

@section('content')

<div class="container">

<div class="card shadow">

<div class="card-header bg-warning">

<h4>Edit Link Publikasi</h4>

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

<form action="{{ route('links.update',$link) }}" method="POST">

@csrf
@method('PUT')

<div class="mb-3">

<label>Kegiatan</label>

<select
name="activity_id"
class="form-select"
required>

@foreach($activities as $activity)

<option
value="{{ $activity->id }}"
{{ $activity->id==$link->activity_id?'selected':'' }}>

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
value="{{ $link->title }}"
required>

</div>

<div class="mb-3">

<label>Platform</label>

<input
type="text"
name="platform"
class="form-control"
value="{{ $link->platform }}"
required>

</div>

<div class="mb-3">

<label>URL</label>

<input
type="url"
name="url"
class="form-control"
value="{{ $link->url }}"
required>

</div>

<button class="btn btn-warning">

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