@extends('layouts.app')

@section('title','Data Instansi')

@section('content')

<div class="container-fluid">

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card shadow">

        <div class="card-header bg-primary text-white">

            <div class="d-flex justify-content-between align-items-center">

                <h5 class="mb-0">
                    Data Instansi
                </h5>

                <a href="{{ route('institutions.create') }}"
                   class="btn btn-light btn-sm">

                    <i class="bi bi-plus-circle"></i>
                    Tambah Instansi

                </a>

            </div>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('institutions.index') }}"
                  class="mb-3">

                <div class="row">

                    <div class="col-md-4">

                        <div class="input-group">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari instansi..."
                                value="{{ $search }}">

                            <button
                                class="btn btn-primary"
                                type="submit">

                                <i class="bi bi-search"></i>

                            </button>

                            @if(request('search'))

                                <a href="{{ route('institutions.index') }}"
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

                    <thead class="table-dark">

                        <tr>

                            <th width="70">No</th>

                            <th>Nama Instansi</th>

                            <th>Alamat</th>

                            <th>Website</th>

                            <th width="180">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($institutions as $institution)

                            <tr>

                                <td>

                                    {{ $institutions->firstItem() + $loop->index }}

                                </td>

                                <td>

                                    {{ $institution->name }}

                                </td>

                                <td>

                                    {{ $institution->address ?: '-' }}

                                </td>

                                <td>

                                    @if($institution->website)

                                        <a href="{{ $institution->website }}"
                                           target="_blank">

                                            {{ $institution->website }}

                                        </a>

                                    @else

                                        -

                                    @endif

                                </td>

                                <td>

                                    <a href="{{ route('institutions.edit',$institution) }}"
                                       class="btn btn-warning btn-sm">

                                        <i class="bi bi-pencil-square"></i>

                                    </a>

                                    <form
                                        action="{{ route('institutions.destroy',$institution) }}"
                                        method="POST"
                                        class="d-inline">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm">

                                            <i class="bi bi-trash"></i>

                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5"
                                    class="text-center">

                                    Belum ada data instansi.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-end mt-3">

                {{ $institutions->links() }}

            </div>

        </div>

    </div>

</div>

@endsection