@extends('layouts.app')

@section('title','Edit Instansi')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-warning text-dark">

            <h5 class="mb-0">
                <i class="bi bi-pencil-square"></i>
                Edit Instansi
            </h5>

        </div>

        <div class="card-body">

            <form action="{{ route('institutions.update',$institution) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <div class="mb-3">

                    <label class="form-label fw-semibold">

                        Nama Instansi

                    </label>

                    <input
                        type="text"
                        name="name"
                        class="form-control @error('name') is-invalid @enderror"
                        value="{{ old('name',$institution->name) }}">

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
                        class="form-control">{{ old('address',$institution->address) }}</textarea>

                </div>

                <div class="mb-4">

                    <label class="form-label fw-semibold">

                        Website

                    </label>

                    <input
                        type="text"
                        name="website"
                        class="form-control"
                        value="{{ old('website',$institution->website) }}">

                </div>

                <button class="btn btn-warning text-white">

                    <i class="bi bi-check-circle"></i>

                    Update

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