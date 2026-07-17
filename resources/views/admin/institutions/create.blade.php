@extends('layouts.app')

@section('title','Tambah Instansi')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-success text-white d-flex justify-content-between align-items-center">

            <h5 class="mb-0">
                <i class="bi bi-building-add"></i>
                Tambah Instansi
            </h5>

            <a href="{{ route('institutions.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i>
                Kembali
            </a>

        </div>

        <div class="card-body">

            <form action="{{ route('institutions.store') }}" method="POST">

                @csrf

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Nama Instansi
                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name') }}"
                        placeholder="Masukkan nama instansi">

                    @error('name')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror

                </div>

                <div class="mb-3">

                    <label class="form-label fw-semibold">
                        Alamat
                    </label>

                    <textarea
                        name="address"
                        rows="3"
                        class="form-control @error('address') is-invalid @enderror"
                        placeholder="Masukkan alamat">{{ old('address') }}</textarea>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">
                        Website
                    </label>

                    <input
                        type="url"
                        name="website"
                        class="form-control @error('website') is-invalid @enderror"
                        value="{{ old('website') }}"
                        placeholder="https://example.com">

                </div>

                <button class="btn btn-success">

                    <i class="bi bi-save"></i>

                    Simpan

                </button>

                <a href="{{ route('institutions.index') }}"
                   class="btn btn-secondary">

                    <i class="bi bi-x-circle"></i>

                    Batal

                </a>

            </form>

        </div>

    </div>

</div>

@endsection