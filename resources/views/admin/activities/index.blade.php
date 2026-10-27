
@extends('layouts.app')

@section('title', 'Daftar Kegiatan')

@section('content')

<div class="container-fluid">

    <div class="card shadow border-0">

        <div class="card-header bg-primary text-white">

            <div class="d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">

                <h4 class="mb-0">
                    <i class="bi bi-calendar-event"></i>
                    Daftar Kegiatan
                </h4>

                <a href="{{ route('activities.create') }}" class="btn btn-light">
                    <i class="bi bi-plus-circle"></i>
                    Tambah Kegiatan
                </a>

            </div>

        </div>

        <div class="card-body">

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="GET"
                  action="{{ route('activities.index') }}"
                  class="mb-4">

                <div class="row g-2">

                    <div class="col-lg-5 col-md-8">

                        <div class="input-group">

                            <input
                                type="text"
                                name="search"
                                class="form-control"
                                placeholder="Cari judul, lokasi, atau penanggung jawab..."
                                value="{{ request('search') }}">

                            <select name="status" class="form-select">
                                <option value="">Semua Status</option>

                                @foreach (['Draft', 'Terjadwal', 'Dipublikasikan', 'Selesai'] as $status)
                                    <option
                                        value="{{ $status }}"
                                        {{ request('status') == $status ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>

                            <button class="btn btn-primary" type="submit" title="Cari">
                                <i class="bi bi-search"></i>
                            </button>

                            @if(request('search') || request('status'))
                                <a href="{{ route('activities.index') }}"
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
                            <th>Judul Kegiatan</th>
                            <th>Kategori</th>
                            <th width="150">Tanggal Kegiatan</th>
                            <th width="160">Status</th>
                            <th width="150">Aksi</th>
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

                                    @if ($activity->location)
                                        <div class="text-muted small">
                                            <i class="bi bi-geo-alt"></i>
                                            {{ $activity->location }}
                                        </div>
                                    @endif
                                </td>

                                <td>
                                    {{ $activity->category->name ?? '-' }}
                                </td>

                                <td class="text-center">
                                    {{ $activity->activity_date
                                        ? \Illuminate\Support\Carbon::parse($activity->activity_date)->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td class="text-center">

                                    @php
                                        $statusClass = match ($activity->status) {
                                            'Draft' => 'bg-secondary',
                                            'Terjadwal' => 'bg-warning text-dark',
                                            'Dipublikasikan' => 'bg-success',
                                            'Selesai' => 'bg-primary',
                                            default => 'bg-secondary',
                                        };
                                    @endphp

                                    <span class="badge {{ $statusClass }}">
                                        {{ $activity->status ?? '-' }}
                                    </span>

                                </td>

                                <td class="text-center">

                                    {{-- Detail --}}
                                    <a href="{{ route('activities.show', $activity->id) }}"
                                       class="btn btn-info btn-sm"
                                       title="Detail Kegiatan"
                                       aria-label="Detail Kegiatan">
                                        <i class="bi bi-eye"></i>
                                    </a>

                                    {{-- Edit --}}
                                    <a href="{{ route('activities.edit', $activity->id) }}"
                                       class="btn btn-warning btn-sm"
                                       title="Edit Kegiatan"
                                       aria-label="Edit Kegiatan">
                                        <i class="bi bi-pencil-square"></i>
                                    </a>

                                    {{-- Hapus --}}
                                    <form
                                        action="{{ route('activities.destroy', $activity->id) }}"
                                        method="POST"
                                        class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus kegiatan ini? Data yang dihapus tidak dapat dipulihkan.');">

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="btn btn-danger btn-sm delete-confirm"
                                            title="Hapus Kegiatan"
                                            aria-label="Hapus Kegiatan">
                                            <i class="bi bi-trash"></i>
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6" class="text-center py-4">
                                    <i class="bi bi-calendar-x fs-3 d-block mb-2"></i>
                                    Tidak ada data kegiatan.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="d-flex justify-content-center justify-content-md-end mt-4">
                {{ $activities->links() }}
            </div>

        </div>

    </div>

</div>

@endsection
