
@extends('layouts.pemohon')

@section('title', 'Riwayat Pengajuan')

@section('content')

<div class="page-heading">
    <div class="eyebrow">Manajemen pengajuan</div>
    <h1 class="page-title">Riwayat Pengajuan Kegiatan</h1>
    <p class="page-description">
        Pantau seluruh pengajuan kegiatan, status pemeriksaan,
        dan catatan dari Administrator Kominfo Kabupaten Ngawi.
    </p>
</div>

@if (session('success'))
    <div class="alert alert-success">
        <i class="bi bi-check-circle-fill"></i>
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-circle"></i> Terjadi kesalahan:</strong>
        <ul style="margin:8px 0 0;padding-left:20px">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="panel">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:20px">
        <div>
            <h2 class="panel-heading">Daftar Pengajuan Saya</h2>
            <p class="panel-description" style="margin:5px 0 0">
                Data pengajuan yang telah dikirimkan melalui akun Anda.
            </p>
        </div>

        <a href="{{ route('pemohon.submissions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Buat Pengajuan
        </a>
    </div>

    @if ($submissions->count() > 0)
        <div class="table-wrap">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Kegiatan</th>
                        <th>Kategori</th>
                        <th>Instansi</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                        <th>Catatan Administrator</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ($submissions as $submission)
                        @php
                            $status = strtolower(trim($submission->status));
                            $statusClass = 'status-menunggu';

                            if ($status === 'disetujui') {
                                $statusClass = 'status-disetujui';
                            } elseif ($status === 'ditolak') {
                                $statusClass = 'status-ditolak';
                            } elseif ($status === 'perlu revisi') {
                                $statusClass = 'status-revisi';
                            }
                        @endphp

                        <tr>
                            <td>{{ $submissions->firstItem() + $loop->index }}</td>

                            <td>
                                <strong style="color:#284433">
                                    {{ $submission->title }}
                                </strong>

                                @if ($submission->location)
                                    <div style="font-size:11px;color:#78877f;margin-top:5px">
                                        <i class="bi bi-geo-alt"></i>
                                        {{ $submission->location }}
                                    </div>
                                @endif
                            </td>

                            <td>{{ $submission->category->name ?? '-' }}</td>
                            <td>{{ $submission->institution->name ?? '-' }}</td>

                            <td>
                                {{ $submission->activity_date
                                    ? $submission->activity_date->format('d-m-Y')
                                    : '-' }}
                            </td>

                            <td>
                                <span class="badge-status {{ $statusClass }}">
                                    {{ $submission->status }}
                                </span>
                            </td>

                            <td>
                                @if ($submission->admin_note)
                                    @if ($status === 'perlu revisi')
                                        <div class="note-box">
                                            <strong>
                                                <i class="bi bi-chat-left-text"></i>
                                                Catatan Revisi
                                            </strong>
                                            <div style="margin-top:5px">
                                                {{ $submission->admin_note }}
                                            </div>
                                        </div>
                                    @else
                                        <span style="color:#65756b;line-height:1.6">
                                            {{ $submission->admin_note }}
                                        </span>
                                    @endif
                                @else
                                    <span style="color:#9aa59e">Belum ada catatan.</span>
                                @endif
                            </td>

                            <td>
                                @if ($status === 'perlu revisi' && is_null($submission->activity_id))
                                    <a href="{{ route('pemohon.submissions.edit', $submission->id) }}"
                                       class="btn btn-warning">
                                        <i class="bi bi-pencil-square"></i> Edit
                                    </a>
                                @elseif ($status === 'disetujui')
                                    <span style="color:#16834b;font-size:11px;font-weight:700">
                                        <i class="bi bi-check-circle"></i> Disetujui
                                    </span>
                                @elseif ($status === 'ditolak')
                                    <span style="color:#b42332;font-size:11px">
                                        <i class="bi bi-lock"></i> Tidak dapat diedit
                                    </span>
                                @else
                                    <span style="color:#8a6500;font-size:11px">
                                        <i class="bi bi-hourglass-split"></i> Menunggu
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="pagination">
            {{ $submissions->links('pagination::simple-default') }}
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-folder2-open"></i>
            <h3>Belum Ada Pengajuan</h3>
            <p>
                Anda belum mengirimkan pengajuan kegiatan.
                Silakan buat pengajuan pertama melalui tombol berikut.
            </p>
            <a href="{{ route('pemohon.submissions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Buat Pengajuan Sekarang
            </a>
        </div>
    @endif
</div>

@endsection
