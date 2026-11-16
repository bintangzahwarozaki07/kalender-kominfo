
@extends('layouts.app')

@section('title', 'Detail Pengajuan')

@section('content')

<div class="container-fluid">

    <div class="d-flex justify-content-between align-items-center flex-wrap gap-2 mb-4">

        <div>
            <h3 class="fw-bold mb-1">Detail Pengajuan Kegiatan</h3>
            <p class="text-muted mb-0">
                Periksa informasi sebelum memutuskan pengajuan.
            </p>
        </div>

        <a href="{{ route('admin.submissions.index') }}"
           class="btn btn-secondary">
            <i class="bi bi-arrow-left me-1"></i>
            Kembali
        </a>

    </div>

    @if ($errors->any())
        <div class="alert alert-danger">
            <strong>Terjadi kesalahan:</strong>
            <ul class="mb-0 mt-2">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @php
        $statusClass = match($submission->status) {
            'Menunggu' => 'bg-warning text-dark',
            'Disetujui' => 'bg-success',
            'Ditolak' => 'bg-danger',
            'Perlu Revisi' => 'bg-primary',
            default => 'bg-secondary',
        };
    @endphp

    <div class="card border-0 shadow-sm mb-4">

        <div class="card-header bg-white py-3">
            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                <h5 class="fw-bold mb-0">Informasi Pengajuan</h5>

                <span class="badge {{ $statusClass }} fs-6">
                    {{ $submission->status }}
                </span>
            </div>
        </div>

        <div class="card-body">

            <div class="row g-4">

                <div class="col-md-6">
                    <small class="text-muted">Nama Pemohon</small>
                    <div class="fw-semibold">
                        {{ $submission->user->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Email Pemohon</small>
                    <div class="fw-semibold">
                        {{ $submission->user->email ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Nama Kegiatan</small>
                    <div class="fw-semibold">
                        {{ $submission->title }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Kategori</small>
                    <div class="fw-semibold">
                        {{ $submission->category->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Instansi</small>
                    <div class="fw-semibold">
                        {{ $submission->institution->name ?? '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Tanggal Kegiatan</small>
                    <div class="fw-semibold">
                        {{ $submission->activity_date
                            ? $submission->activity_date->format('d-m-Y')
                            : '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Waktu Mulai</small>
                    <div class="fw-semibold">
                        {{ $submission->start_time
                            ? substr((string) $submission->start_time, 0, 5)
                            : '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Waktu Selesai</small>
                    <div class="fw-semibold">
                        {{ $submission->end_time
                            ? substr((string) $submission->end_time, 0, 5)
                            : '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Lokasi</small>
                    <div class="fw-semibold">
                        {{ $submission->location ?: '-' }}
                    </div>
                </div>

                <div class="col-md-6">
                    <small class="text-muted">Penanggung Jawab</small>
                    <div class="fw-semibold">
                        {{ $submission->person_in_charge ?: '-' }}
                    </div>
                </div>

                <div class="col-12">
                    <small class="text-muted">Deskripsi Kegiatan</small>
                    <div class="border rounded p-3 mt-1" style="white-space: pre-line;">
                        {{ $submission->description ?: 'Tidak ada deskripsi.' }}
                    </div>
                </div>

                <div class="col-12">
                    <small class="text-muted">Catatan Administrator</small>
                    <div class="border rounded p-3 mt-1">
                        {{ $submission->admin_note ?: 'Belum ada catatan.' }}
                    </div>
                </div>

                @if ($submission->activity_id)
                    <div class="col-12">
                        <div class="alert alert-success mb-0">
                            Pengajuan ini sudah terhubung dengan data kegiatan resmi
                            dengan ID {{ $submission->activity_id }}.
                        </div>
                    </div>
                @endif

            </div>

        </div>
    </div>

    @if (in_array($submission->status, ['Menunggu', 'Perlu Revisi']) && !$submission->activity_id)

        <div class="card border-0 shadow-sm">

            <div class="card-header bg-white py-3">
                <h5 class="fw-bold mb-0">Tindakan Administrator</h5>
            </div>

            <div class="card-body">

                <div class="alert alert-info">
                    Periksa informasi kegiatan terlebih dahulu.
                    Jika disetujui, data kegiatan akan otomatis ditambahkan
                    ke menu Kegiatan dengan status Terjadwal.
                </div>

                {{-- Form persetujuan --}}
                <form
                    action="{{ route('admin.submissions.approve', $submission) }}"
                    method="POST"
                    class="mb-4"
                    onsubmit="return confirm('Apakah kamu yakin ingin menyetujui pengajuan ini? Data akan dibuat menjadi kegiatan resmi.');"
                >
                    @csrf

                    <label class="form-label fw-semibold">
                        Catatan Persetujuan (Opsional)
                    </label>

                    <textarea
                        name="admin_note"
                        class="form-control mb-3"
                        rows="2"
                        placeholder="Tambahkan catatan jika diperlukan..."
                    >{{ old('admin_note') }}</textarea>

                    <button type="submit" class="btn btn-success">
                        <i class="bi bi-check-circle me-1"></i>
                        Setujui Pengajuan
                    </button>
                </form>

                <hr>

                {{-- Form permintaan revisi --}}
                <form
                    action="{{ route('admin.submissions.revision', $submission) }}"
                    method="POST"
                    class="mb-4"
                    onsubmit="return confirm('Kirim permintaan revisi kepada Pemohon?');"
                >
                    @csrf

                    <label class="form-label fw-semibold">
                        Catatan Revisi <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="admin_note"
                        class="form-control mb-3"
                        rows="3"
                        placeholder="Jelaskan bagian yang harus diperbaiki..."
                        required
                    >{{ old('admin_note') }}</textarea>

                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-pencil-square me-1"></i>
                        Minta Revisi
                    </button>
                </form>

                <hr>

                {{-- Form penolakan --}}
                <form
                    action="{{ route('admin.submissions.reject', $submission) }}"
                    method="POST"
                    onsubmit="return confirm('Apakah kamu yakin ingin menolak pengajuan ini?');"
                >
                    @csrf

                    <label class="form-label fw-semibold">
                        Alasan Penolakan <span class="text-danger">*</span>
                    </label>

                    <textarea
                        name="admin_note"
                        class="form-control mb-3"
                        rows="3"
                        placeholder="Tuliskan alasan penolakan..."
                        required
                    >{{ old('admin_note') }}</textarea>

                    <button type="submit" class="btn btn-danger">
                        <i class="bi bi-x-circle me-1"></i>
                        Tolak Pengajuan
                    </button>
                </form>

            </div>
        </div>

    @endif

</div>

@endsection
