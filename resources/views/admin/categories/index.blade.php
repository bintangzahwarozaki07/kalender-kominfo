@extends('layouts.app')

@section('title','Data Kategori')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

                <h4 class="mb-0">
                    <i class="bi bi-folder2-open"></i>
                    Data Kategori
                </h4>

                <a href="{{ route('categories.create') }}"
                   class="btn btn-light">

                    <i class="bi bi-plus-circle"></i>
                    Tambah Kategori

                </a>

            </div>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('categories.index') }}"
                  class="mb-4">

                <div class="row g-2">

                    <div class="col-lg-5 col-md-8">

                        <div class="input-group">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari kategori..."
                                value="{{ request('search') }}">

                            <button
                                class="btn btn-primary"
                                type="submit">

                                <i class="bi bi-search"></i>

                            </button>

                            @if(request('search'))

                                <a href="{{ route('categories.index') }}"
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

                            <th width="70">No</th>

                            <th>Nama Kategori</th>

                            <th>Slug</th>

                            <th>Deskripsi</th>

                            <th width="150">Aksi</th>

                        </tr>

                    </thead>

                    <tbody>

                        @forelse($categories as $category)

                        <tr>

                            <td class="text-center">

                                {{ $categories->firstItem() + $loop->index }}

                            </td>

                            <td>

                                <strong>{{ $category->name }}</strong>

                            </td>

                            <td>

                                <span class="badge bg-secondary">

                                    {{ $category->slug }}

                                </span>

                            </td>

                            <td>

                                {{ $category->description ?: '-' }}

                            </td>

                            <td class="text-center">

                                <a href="{{ route('categories.edit',$category) }}"
                                   class="btn btn-warning btn-sm">

                                    <i class="bi bi-pencil-square"></i>

                                </a>

                                <form
                                    action="{{ route('categories.destroy',$category) }}"
                                    method="POST"
                                    class="d-inline">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm delete-confirm">

                                        <i class="bi bi-trash"></i>

                                    </button>

                                </form>

                            </td>

                        </tr>

                        @empty

                        <tr>

                            <td colspan="5"
                                class="text-center py-4">

                                <i class="bi bi-folder-x fs-3 d-block mb-2"></i>

                                Tidak ada data kategori.

                            </td>

                        </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-center justify-content-md-end mt-4">

                {{ $categories->links() }}

            </div>

        </div>

    </div>

</div>

@endsection