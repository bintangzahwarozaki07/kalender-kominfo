
@extends('layouts.app')

@section('title', 'Publikasi & Dokumentasi')

@section('content')

<div class="card shadow">

    <div class="card-header bg-primary text-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">

            <h4 class="mb-0">
                <i class="bi bi-collection"></i>
                Publikasi & Dokumentasi
            </h4>

            <div class="d-flex gap-2 flex-wrap">
                <a href="{{ route('links.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Link
                </a>

                <a href="{{ route('documentations.create') }}" class="btn btn-light btn-sm">
                    <i class="bi bi-images"></i>
                    Tambah Dokumentasi
                </a>
            </div>

        </div>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <form action="{{ route('publication-documentations.index') }}"
              method="GET"
              class="mb-4">

            <div class="row">
                <div class="col-md-6">

                    <div class="input-group">

                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari nama kegiatan, link, platform, atau caption..."
                            value="{{ request('search') }}">

                        <button class="btn btn-primary">
                            <i class="bi bi-search"></i>
                            Cari
                        </button>

                        @if(request('search'))
                            <a href="{{ route('publication-documentations.index') }}"
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
                        <th width="55">No.</th>
                        <th width="210">Nama Kegiatan</th>
                        <th width="115">Tanggal</th>
                        <th>Link Publikasi</th>
                        <th width="260">Dokumentasi</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($activities as $activity)

                        <tr>

                            <td class="text-center">
                                {{ $activities->firstItem() + $loop->index }}
                            </td>

                            <td>
                                <strong>{{ $activity->title }}</strong>
                            </td>

                            <td class="text-center">
                                {{ $activity->activity_date
                                    ? $activity->activity_date->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>

                                @forelse($activity->links as $link)

                                    <div class="mb-2 p-2 border rounded">

                                        <div class="mb-1">
                                            <span class="badge bg-primary">
                                                {{ $link->platform }}
                                            </span>
                                        </div>

                                        <div class="mb-2">
                                            <strong>{{ $link->title }}</strong>
                                        </div>

                                        <a href="{{ $link->url }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="text-decoration-none">

                                            <i class="bi bi-box-arrow-up-right"></i>
                                            Buka Publikasi

                                        </a>

                                        <div class="mt-2">

                                            <a href="{{ route('links.edit', $link) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('links.destroy', $link) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm delete-confirm">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                @empty

                                    <span class="text-muted">- Belum ada link publikasi -</span>

                                @endforelse

                            </td>

                            <td>

                                @forelse($activity->documentations as $documentation)

                                    <div class="d-inline-block text-center border rounded p-2 m-1">

                                        @if($documentation->photo)
                                            <a href="{{ asset('uploads/documentations/'.$documentation->photo) }}"
                                               target="_blank">

                                                <img
                                                    src="{{ asset('uploads/documentations/'.$documentation->photo) }}"
                                                    alt="Dokumentasi kegiatan"
                                                    class="rounded"
                                                    style="width:100px;height:75px;object-fit:cover;">

                                            </a>
                                        @else
                                            <span class="text-muted">Foto tidak tersedia</span>
                                        @endif

                                        @if($documentation->caption)
                                            <div class="small mt-1">
                                                {{ $documentation->caption }}
                                            </div>
                                        @endif

                                        @if($documentation->is_cover)
                                            <span class="badge bg-success mt-1">Cover</span>
                                        @endif

                                        <div class="mt-2">

                                            <a href="{{ route('documentations.edit', $documentation) }}"
                                               class="btn btn-warning btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>

                                            <form action="{{ route('documentations.destroy', $documentation) }}"
                                                  method="POST"
                                                  class="d-inline">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        class="btn btn-danger btn-sm delete-confirm">
                                                    <i class="bi bi-trash"></i>
                                                </button>

                                            </form>

                                        </div>

                                    </div>

                                @empty

                                    <span class="text-muted">- Belum ada dokumentasi -</span>

                                @endforelse

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" class="text-center py-4">
                                <i class="bi bi-inbox fs-3 d-block mb-2"></i>
                                Belum ada data kegiatan, publikasi, atau dokumentasi.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $activities->links() }}
        </div>

    </div>

</div>

@endsection
