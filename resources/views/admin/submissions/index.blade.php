@extends('layouts.app')

@section('title', 'Pengajuan Pemohon')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">
        <div>
            <h3 class="fw-bold mb-1">Pengajuan Kegiatan Pemohon</h3>
            <p class="text-muted mb-0">
                Daftar pengajuan kegiatan yang dikirimkan oleh pengguna.
            </p>
        </div>
    </div>

    @php
        $menunggu = $submissions->where('status', 'Menunggu')->count();
        $disetujui = $submissions->where('status', 'Disetujui')->count();
        $ditolak = $submissions->where('status', 'Ditolak')->count();
        $revisi = $submissions->where('status', 'Perlu Revisi')->count();
    @endphp

    <div class="row g-3 mb-4">

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Menunggu</small>
                    <h3 class="fw-bold text-warning mb-0">{{ $menunggu }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Disetujui</small>
                    <h3 class="fw-bold text-success mb-0">{{ $disetujui }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Ditolak</small>
                    <h3 class="fw-bold text-danger mb-0">{{ $ditolak }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <small class="text-muted">Perlu Revisi</small>
                    <h3 class="fw-bold text-primary mb-0">{{ $revisi }}</h3>
                </div>
            </div>
        </div>

    </div>

    <div class="card border-0 shadow-sm">
        <div class="card-body">

            <div class="table-responsive">

                <table class="table table-bordered table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th width="55">No.</th>
                            <th>Pemohon</th>
                            <th>Nama Kegiatan</th>
                            <th>Kategori</th>
                            <th>Instansi</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                            <th width="110">Aksi</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse ($submissions as $submission)

                            @php
                                $statusClass = match($submission->status) {
                                    'Menunggu' => 'bg-warning text-dark',
                                    'Disetujui' => 'bg-success',
                                    'Ditolak' => 'bg-danger',
                                    'Perlu Revisi' => 'bg-primary',
                                    default => 'bg-secondary',
                                };
                            @endphp

                            <tr>
                                <td>
                                    {{ $submissions->firstItem() + $loop->index }}
                                </td>

                                <td>
                                    <strong>
                                        {{ $submission->user->name ?? 'Pengguna tidak ditemukan' }}
                                    </strong>
                                    <br>
                                    <small class="text-muted">
                                        {{ $submission->user->email ?? '-' }}
                                    </small>
                                </td>

                                <td>
                                    {{ $submission->title }}
                                </td>

                                <td>
                                    {{ $submission->category->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $submission->institution->name ?? '-' }}
                                </td>

                                <td>
                                    {{ $submission->activity_date
                                        ? $submission->activity_date->format('d-m-Y')
                                        : '-' }}
                                </td>

                                <td>
                                    <span class="badge {{ $statusClass }}">
                                        {{ $submission->status }}
                                    </span>
                                </td>

                                <td>
                                    <a
                                        href="{{ route('admin.submissions.show', $submission) }}"
                                        class="btn btn-sm btn-success"
                                    >
                                        <i class="bi bi-eye me-1"></i>
                                        Detail
                                    </a>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="text-center py-5">
                                    <i class="bi bi-inbox fs-1 text-muted"></i>

                                    <p class="text-muted mt-2 mb-0">
                                        Belum ada pengajuan kegiatan dari Pemohon.
                                    </p>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            <div class="mt-3">
                {{ $submissions->links() }}
            </div>

        </div>
    </div>

</div>

@endsection
