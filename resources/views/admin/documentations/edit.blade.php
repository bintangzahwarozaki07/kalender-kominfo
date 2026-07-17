@extends('layouts.app')

@section('title','Edit Dokumentasi')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-warning">
            <h4 class="mb-0">
                Edit Dokumentasi
            </h4>
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

            <form action="{{ route('documentations.update',$documentation) }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label">
                        Pilih Kegiatan
                    </label>

                    <select
                        name="activity_id"
                        class="form-select"
                        required>

                        @foreach($activities as $activity)

                            <option
                                value="{{ $activity->id }}"
                                {{ old('activity_id',$documentation->activity_id)==$activity->id?'selected':'' }}>

                                {{ $activity->title }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Preview Foto
                    </label>

                    <br>

                    <img
                        id="preview"
                        src="{{ asset('uploads/documentations/'.$documentation->photo) }}"
                        width="300"
                        class="img-thumbnail">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Ganti Foto
                    </label>

                    <input
                        type="file"
                        id="photo"
                        name="photo"
                        class="form-control"
                        accept="image/*">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Caption
                    </label>

                    <textarea
                        name="caption"
                        rows="4"
                        class="form-control">{{ old('caption',$documentation->caption) }}</textarea>

                </div>

                <div class="form-check mb-4">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="is_cover"
                        value="1"
                        id="cover"
                        {{ old('is_cover',$documentation->is_cover)?'checked':'' }}>

                    <label
                        class="form-check-label"
                        for="cover">

                        Jadikan Cover

                    </label>

                </div>

                <button class="btn btn-primary">
                    Update
                </button>

                <a href="{{ route('documentations.index') }}"
                   class="btn btn-secondary">
                    Kembali
                </a>

            </form>

        </div>

    </div>

</div>

<script>

document.getElementById('photo').addEventListener('change',function(e){

    let file=e.target.files[0];

    if(file){

        document.getElementById('preview').src=
        URL.createObjectURL(file);

    }

});

</script>

@endsection