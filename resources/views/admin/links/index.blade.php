@extends('layouts.app')

@section('title','Link Publikasi')

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">

        <div class="d-flex justify-content-between align-items-center flex-wrap">

            <h4 class="mb-2 mb-md-0">

                <i class="bi bi-link-45deg"></i>

                Link Publikasi

            </h4>

            <a href="{{ route('links.create') }}"
               class="btn btn-light">

                <i class="bi bi-plus-circle"></i>

                Tambah Link

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

        <form action="{{ route('links.index') }}"
              method="GET"
              class="mb-4">

            <div class="row">

                <div class="col-md-6">

                    <div class="input-group">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari Judul, Platform, URL atau Kegiatan..."
                            value="{{ request('search') }}">

                        <button class="btn btn-primary">

                            <i class="bi bi-search"></i>

                            Cari

                        </button>

                        @if(request('search'))

                        <a href="{{ route('links.index') }}"
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

                    <th>Judul</th>

                    <th width="140">Platform</th>

                    <th>Link</th>

                    <th width="170">Aksi</th>

                </tr>

                </thead>

                <tbody>

                @forelse($links as $link)

                <tr>

                    <td class="text-center">

                        {{ $links->firstItem() + $loop->index }}

                    </td>

                    <td>

                        {{ optional($link->activity)->title }}

                    </td>

                    <td>

                        {{ $link->title }}

                    </td>

                    <td class="text-center">

                        <span class="badge bg-primary">

                            {{ $link->platform }}

                        </span>

                    </td>

                    <td>

                        <a href="{{ $link->url }}"
                           target="_blank"
                           class="text-decoration-none">

                            <i class="bi bi-box-arrow-up-right"></i>

                            Buka Link

                        </a>

                    </td>

                    <td class="text-center">

                        <a href="{{ route('links.edit',$link) }}"
                           class="btn btn-warning btn-sm">

                            <i class="bi bi-pencil"></i>

                        </a>

                        <form action="{{ route('links.destroy',$link) }}"
                              method="POST"
                              class="d-inline">

                            @csrf

                            @method('DELETE')

                            <button
                                class="btn btn-danger btn-sm delete-confirm">

                                <i class="bi bi-trash"></i>

                            </button>

                        </form>

                    </td>

                </tr>

                @empty

                <tr>

                    <td colspan="6"
                        class="text-center">

                        Belum ada data Link Publikasi.

                    </td>

                </tr>

                @endforelse

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-center mt-4">

            {{ $links->links() }}

        </div>

    </div>

</div>

@endsection