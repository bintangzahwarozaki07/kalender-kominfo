
@extends('layouts.app')

@section('title', 'Detail Kegiatan')

@section('content')
<div class="container py-4">

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <h2 class="mb-0">Detail Kegiatan</h2>

        <a href="{{ route('activities.index') }}" class="btn btn-secondary">
            Kembali ke Daftar
        </a>
    </div>

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

    <div class="card shadow-sm border-0">

        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">{{ $activity->title }}</h5>
        </div>

        <div class="card-body">

            @if ($activity->thumbnail)
                <div class="text-center mb-4">
                    <img
                        src="{{ asset('uploads/activities/' . $activity->thumbnail) }}"
                        alt="Thumbnail kegiatan"
                        class="img-fluid rounded shadow-sm"
                        style="max-width: 400px; max-height: 300px; object-fit: contain;"
                    >
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-bordered table-striped align-middle">
                    <tbody>
                        <tr>
                            <th style="width: 30%;">Judul Kegiatan</th>
                            <td>{{ $activity->title }}</td>
                        </tr>

                        <tr>
                            <th>Kategori</th>
                            <td>{{ $activity->category->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Instansi</th>
                            <td>{{ $activity->institution->name ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Tanggal Kegiatan</th>
                            <td>
                                {{ $activity->activity_date
                                    ? \Illuminate\Support\Carbon::parse($activity->activity_date)->format('d-m-Y')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Jam Mulai</th>
                            <td>
                                {{ $activity->start_time
                                    ? substr((string) $activity->start_time, 0, 5)
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Jam Selesai</th>
                            <td>
                                {{ $activity->end_time
                                    ? substr((string) $activity->end_time, 0, 5)
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Tanggal Publikasi</th>
                            <td>
                                {{ $activity->publish_date
                                    ? \Illuminate\Support\Carbon::parse($activity->publish_date)->format('d-m-Y')
                                    : '-' }}
                            </td>
                        </tr>

                        <tr>
                            <th>Lokasi</th>
                            <td>{{ $activity->location ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Penanggung Jawab</th>
                            <td>{{ $activity->person_in_charge ?? '-' }}</td>
                        </tr>

                        <tr>
                            <th>Status</th>
                            <td>
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
                        </tr>

                        <tr>
                            <th>Deskripsi</th>
                            <td>
                                @if ($activity->description)
                                    {!! nl2br(e($activity->description)) !!}
                                @else
                                    -
                                @endif
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            @if ($activity->documentations && $activity->documentations->isNotEmpty())
                <div class="mt-4">
                    <h5 class="mb-3">Dokumentasi Kegiatan</h5>

                    <div class="row">
                        @foreach ($activity->documentations as $documentation)
                            <div class="col-md-4 mb-3">
                                <div class="card h-100">
                                    @if (!empty($documentation->file_path))
                                        <img
                                            src="{{ asset('storage/' . $documentation->file_path) }}"
                                            class="card-img-top"
                                            alt="Dokumentasi kegiatan"
                                            style="height: 200px; object-fit: cover;"
                                        >
                                    @endif

                                    <div class="card-body">
                                        <p class="mb-0">
                                            {{ $documentation->title ?? $documentation->description ?? 'Dokumentasi kegiatan' }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            @if ($activity->links && $activity->links->isNotEmpty())
                <div class="mt-4">
                    <h5 class="mb-3">Tautan Terkait</h5>

                    <ul class="list-group">
                        @foreach ($activity->links as $link)
                            <li class="list-group-item">
                                <a
                                    href="{{ $link->url ?? $link->link_url ?? '#' }}"
                                    target="_blank"
                                    rel="noopener noreferrer"
                                >
                                    {{ $link->title ?? $link->name ?? $link->url ?? 'Buka tautan' }}
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <hr class="my-4">

            <div class="d-flex flex-wrap gap-2 align-items-center">

                <a
                    href="{{ route('activities.edit', $activity->id) }}"
                    class="btn btn-warning"
                >
                    Edit Kegiatan
                </a>

                <a
                    href="{{ route('activities.export.pdf', $activity->id) }}"
                    class="btn btn-danger"
                >
                    Unduh PDF
                </a>

                <form
                    action="{{ route('activities.destroy', $activity->id) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus kegiatan ini? Penghapusan ini tidak dapat dibatalkan.');"
                    class="m-0"
                >
                    @csrf
                    @method('DELETE')

                    <button type="submit" class="btn btn-dark">
                        Hapus Kegiatan
                    </button>
                </form>

                <a
                    href="{{ route('activities.index') }}"
                    class="btn btn-secondary"
                >
                    Kembali ke Daftar
                </a>

            </div>

        </div>
    </div>
</div>
@endsection
