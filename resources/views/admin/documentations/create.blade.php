@extends('layouts.app')

@section('title','Tambah Dokumentasi')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">
                Tambah Dokumentasi
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

            <form action="{{ route('documentations.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Pilih Kegiatan
                    </label>

                    <select
                        name="activity_id"
                        class="form-select"
                        required>

                        <option value="">
                            -- Pilih Kegiatan --
                        </option>

                        @foreach($activities as $activity)

                            <option
                                value="{{ $activity->id }}"
                                {{ old('activity_id')==$activity->id?'selected':'' }}>

                                {{ $activity->title }}

                            </option>

                        @endforeach

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Upload Foto
                    </label>

                    <input
                        type="file"
                        id="photo"
                        name="photo"
                        class="form-control"
                        accept="image/*"
                        required>

                </div>

                <div class="mb-3 text-center">

                    <img
                        id="preview"
                        src="https://placehold.co/300x200?text=Preview+Foto"
                        class="img-thumbnail shadow-sm"
                        width="max-width:300px;border-radius:10px">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Caption
                    </label>

                    <textarea
                        name="caption"
                        rows="4"
                        class="form-control"
                        placeholder="Masukkan caption dokumentasi...">{{ old('caption') }}</textarea>

                </div>

                <div class="form-check mb-4">

                    <input
                        class="form-check-input"
                        type="checkbox"
                        name="is_cover"
                        value="1"
                        id="cover"
                        {{ old('is_cover') ? 'checked':'' }}>

                    <label
                        class="form-check-label"
                        for="cover">

                        Jadikan sebagai Cover

                    </label>

                </div>

                <button class="btn btn-success">
                    Simpan
                </button>

                <a href="{{ route('documentations.index') }}"
                   class="btn btn-secondary">
                    Batal
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