@extends('layouts.app')

@section('title','Tambah Kegiatan')

@section('content')

<div class="container">

    <div class="card shadow">

        <div class="card-header bg-success text-white">
            <h4 class="mb-0">Tambah Kegiatan</h4>
        </div>

        <div class="card-body">

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('activities.store') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf

                <div class="mb-3">

                    <label class="form-label">
                        Kategori
                    </label>

                    <select name="category_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Kategori --
                        </option>

                        @forelse($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ old('category_id')==$category->id?'selected':'' }}>

                                {{ $category->name }}

                            </option>

                        @empty

                            <option disabled>
                                Belum ada kategori.
                            </option>

                        @endforelse

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Instansi
                    </label>

                    <select name="institution_id"
                            class="form-select"
                            required>

                        <option value="">
                            -- Pilih Instansi --
                        </option>

                        @forelse($institutions as $institution)

                            <option value="{{ $institution->id }}"
                                {{ old('institution_id')==$institution->id?'selected':'' }}>

                                {{ $institution->name }}

                            </option>

                        @empty

                            <option disabled>
                                Belum ada instansi.
                            </option>

                        @endforelse

                    </select>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Judul Kegiatan
                    </label>

                    <input type="text"
                           name="title"
                           class="form-control"
                           placeholder="Masukkan judul kegiatan"
                           placeholder="Masukkan lokasi kegiatan"
                           placeholder="Nama penanggung jawab"
                           placeholder="Masukkan deskripsi kegiatan..."
                           value="{{ old('title') }}"
                           required>

                </div>

                <div class="row">

                    <div class="col-md-4">

                        <label class="form-label">
                            Tanggal Kegiatan
                        </label>

                        <input type="date"
                               name="activity_date"
                               class="form-control"
                               value="{{ old('activity_date') }}"
                               required>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Jam Mulai
                        </label>

                        <select name="start_time"
                                class="form-select"
                                required>

                            <option value="">Pilih Jam</option>

                            @for($h=0;$h<24;$h++)
                                @for($m=0;$m<60;$m+=30)

                                    @php
                                        $jam=sprintf('%02d:%02d',$h,$m);
                                    @endphp

                                    <option value="{{ $jam }}"
                                        {{ old('start_time')==$jam?'selected':'' }}>

                                        {{ $jam }}

                                    </option>

                                @endfor
                            @endfor

                        </select>

                    </div>

                    <div class="col-md-4">

                        <label class="form-label">
                            Jam Selesai
                        </label>

                        <select name="end_time"
                                class="form-select"
                                required>

                            <option value="">Pilih Jam</option>

                            @for($h=0;$h<24;$h++)
                                @for($m=0;$m<60;$m+=30)

                                    @php
                                        $jam=sprintf('%02d:%02d',$h,$m);
                                    @endphp

                                    <option value="{{ $jam }}"
                                        {{ old('end_time')==$jam?'selected':'' }}>

                                        {{ $jam }}

                                    </option>

                                @endfor
                            @endfor

                        </select>

                    </div>

                </div>

                <br>

                <div class="mb-3">

                    <label class="form-label">
                        Lokasi
                    </label>

                    <input type="text"
                           name="location"
                           class="form-control"
                           value="{{ old('location') }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Penanggung Jawab
                    </label>

                    <input type="text"
                           name="person_in_charge"
                           class="form-control"
                           value="{{ old('person_in_charge') }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Tanggal Publikasi
                    </label>

                    <input type="date"
                           name="publish_date"
                           class="form-control"
                           value="{{ old('publish_date') }}">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Thumbnail
                    </label>

                    <input type="file"
                           name="thumbnail"
                           class="form-control">

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Deskripsi
                    </label>

                    <textarea name="description"
                              class="form-control"
                              rows="4">{{ old('description') }}</textarea>

                </div>

                <div class="mb-3">

                    <label class="form-label">
                        Status
                    </label>

                    <select name="status"
                            class="form-select">

                        <option value="Draft">Draft</option>
                        <option value="Terjadwal">Terjadwal</option>
                        <option value="Dipublikasikan">Dipublikasikan</option>
                        <option value="Selesai">Selesai</option>

                    </select>

                </div>

                <button class="btn btn-success">

                    Simpan

                </button>

                <a href="{{ route('activities.index') }}"
                   class="btn btn-secondary">

                    Batal

                </a>

            </form>

        </div>

    </div>

</div>

@endsection