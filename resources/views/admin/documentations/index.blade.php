@extends('layouts.app')

@section('title','Data Dokumentasi')

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <h4 class="mb-2 mb-md-0">

                <i class="bi bi-images"></i>

                Data Dokumentasi

            </h4>

            <a href="{{ route('documentations.create') }}"
               class="btn btn-light">

                <i class="bi bi-plus-circle"></i>

                Tambah Dokumentasi

            </a>

        </div>

    </div>

    <div class="card-body">

        @if(session('success'))

        <div class="alert alert-success alert-dismissible fade show">

            {{ session('success') }}

            <button class="btn-close"
                    data-bs-dismiss="alert"></button>

        </div>

        @endif

        <form action="{{ route('documentations.index') }}"
              method="GET"
              class="mb-4">

            <div class="row">

                <div class="col-md-6">

                    <div class="input-group">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari Judul Kegiatan atau Caption..."
                            value="{{ request('search') }}">

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        @if(request('search'))

                        <a href="{{ route('documentations.index') }}"
                           class="btn btn-secondary">

                            Reset

                        </a>

                        @endif

                    </div>

                </div>

            </div>

        </form>

        <div class="table-responsive">

            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">

                <tr>

                    <th width="60">No</th>

                    <th>Kegiatan</th>

                    <th width="140">Foto</th>

                    <th>Caption</th>

                    <th width="90">Cover</th>

                    <th width="170">Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($documentations as $documentation)

                <tr>

                    <td class="text-center">

                        {{ $documentations->firstItem() + $loop->index }}

                    </td>

                    <td>

                        {{ $documentation->activity->title }}

                    </td>

                    <td class="text-center">

                        <img
                            src="{{ asset('uploads/documentations/'.$documentation->photo) }}"
                            class="rounded shadow-sm"
                            style="width:110px;height:80px;object-fit:cover;">

                    </td>

                    <td>

                        {{ $documentation->caption }}

                    </td>

                    <td class="text-center">

                        @if($documentation->is_cover)

                            <span class="badge bg-success">

                                Cover

                            </span>

                        @else

                            <span class="badge bg-secondary">

                                Biasa

                            </span>

                        @endif

                    </td>

                    <td class="text-center">

                        <a href="{{ route('documentations.edit',$documentation) }}"
                           class="btn btn-warning btn-sm"
                           title="Edit Dokumentasi">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form
                            action="{{ route('documentations.destroy',$documentation) }}"
                            method="POST"
                            class="d-inline">

                            @csrf

                            @method('DELETE')

                            <button
                                type="submit"
                                class="btn btn-danger btn-sm delete-confirm"
                                title="Hapus Dokumentasi">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        class="text-center">

                        Belum ada dokumentasi.

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-center mt-4">

            {{ $documentations->links() }}

        </div>

    </div>

</div>

@endsection