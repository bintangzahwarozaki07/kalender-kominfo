
@extends('layouts.app')

@section('title', 'Data Dokumentasi')

@section('content')

<div class="card shadow">

    <div class="card-header bg-success text-white">
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <h4 class="mb-2 mb-md-0">
                <i class="bi bi-images"></i>
                Data Dokumentasi dan Publikasi
            </h4>

            <a href="{{ route('documentations.create') }}" class="btn btn-light">
                <i class="bi bi-plus-circle"></i>
                Tambah Dokumentasi
            </a>
        </div>
    </div>

    <div class="card-body">

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{ session('success') }}
                <button class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        {{-- Pencarian --}}
        <form action="{{ route('documentations.index') }}" method="GET" class="mb-4">
            <div class="row">
                <div class="col-md-7">
                    <div class="input-group">
                        <input
                            type="text"
                            name="search"
                            class="form-control"
                            placeholder="Cari kegiatan, caption, atau link publikasi..."
                            value="{{ request('search') }}">

                        <button class="btn btn-success" type="submit">
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

        {{-- Tabel Dokumentasi --}}
        <h5 class="text-success mb-3">
            <i class="bi bi-images"></i>
            Daftar Dokumentasi
        </h5>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead class="table-dark text-center">
                    <tr>
                        <th width="55">No</th>
                        <th>Kegiatan</th>
                        <th width="130">Foto</th>
                        <th>Caption</th>
                        <th>Link Publikasi</th>
                        <th width="85">Cover</th>
                        <th width="110">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($documentations as $documentation)

                        <tr>
                            <td class="text-center">
                                {{ $documentations->firstItem() + $loop->index }}
                            </td>

                            <td>
                                {{ $documentation->activity?->title ?? 'Kegiatan tidak ditemukan' }}
                            </td>

                            <td class="text-center">
                                @if($documentation->photo)
                                    <img
                                        src="{{ asset('uploads/documentations/'.$documentation->photo) }}"
                                        alt="Foto dokumentasi"
                                        class="rounded shadow-sm"
                                        style="width:110px;height:80px;object-fit:cover;">
                                @else
                                    <span class="text-muted">Tidak ada foto</span>
                                @endif
                            </td>

                            <td>
                                {{ $documentation->caption ?: '-' }}
                            </td>

                            <td>
                                @forelse($documentation->links as $link)
                                    <div class="border rounded p-2 mb-2">
                                        <strong>{{ $link->title }}</strong>

                                        <div class="small text-muted mb-1">
                                            {{ $link->platform }}
                                        </div>

                                        <a href="{{ $link->url }}"
                                           target="_blank"
                                           rel="noopener noreferrer"
                                           class="btn btn-outline-success btn-sm">
                                            <i class="bi bi-box-arrow-up-right"></i>
                                            Buka Publikasi
                                        </a>
                                    </div>
                                @empty
                                    <span class="text-muted small">
                                        Belum ada link publikasi.
                                    </span>
                                @endforelse
                            </td>

                            <td class="text-center">
                                @if($documentation->is_cover)
                                    <span class="badge bg-success">Cover</span>
                                @else
                                    <span class="badge bg-secondary">Biasa</span>
                                @endif
                            </td>

                            <td class="text-center">
                                <a href="{{ route('documentations.edit', $documentation) }}"
                                   class="btn btn-warning btn-sm mb-1"
                                   title="Edit Dokumentasi">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form
                                    action="{{ route('documentations.destroy', $documentation) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus dokumentasi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm mb-1"
                                        title="Hapus Dokumentasi">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted py-4">
                                Belum ada dokumentasi.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

        <div class="d-flex justify-content-center mt-3">
            {{ $documentations->links() }}
        </div>

        {{-- Link Publikasi Lama --}}
        <hr class="my-4">

        <h5 class="text-success mb-2">
            <i class="bi bi-link-45deg"></i>
            Link Publikasi Lama
        </h5>

        <p class="text-muted small">
            Daftar ini menampilkan link publikasi yang sudah tersimpan
            sebelum fitur pengaitan link dengan dokumentasi ditambahkan.
            Data lama tetap dipertahankan.
        </p>

        <div class="table-responsive">
            <table class="table table-bordered table-hover align-middle">

                <thead class="table-secondary text-center">
                    <tr>
                        <th width="55">No</th>
                        <th>Kegiatan</th>
                        <th>Judul Publikasi</th>
                        <th>Platform</th>
                        <th>URL</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($legacyLinks as $link)

                        <tr>
                            <td class="text-center">
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                {{ $link->activity?->title ?? 'Kegiatan tidak ditemukan' }}
                            </td>

                            <td>
                                {{ $link->title }}
                            </td>

                            <td>
                                <span class="badge bg-info text-dark">
                                    {{ $link->platform }}
                                </span>
                            </td>

                            <td>
                                <a href="{{ $link->url }}"
                                   target="_blank"
                                   rel="noopener noreferrer">
                                    Buka Link
                                    <i class="bi bi-box-arrow-up-right"></i>
                                </a>
                            </td>

                            <td class="text-center">
                                <a href="{{ route('links.edit', $link) }}"
                                   class="btn btn-warning btn-sm"
                                   title="Edit Link">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                <form
                                    action="{{ route('links.destroy', $link) }}"
                                    method="POST"
                                    class="d-inline"
                                    onsubmit="return confirm('Yakin ingin menghapus link publikasi ini?')">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn btn-danger btn-sm"
                                        title="Hapus Link">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-muted py-3">
                                Tidak ada link publikasi lama.
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>
        </div>

    </div>
</div>

@endsection
