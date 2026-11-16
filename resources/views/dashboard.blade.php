
@extends('layouts.pemohon')

@section('title', 'Dashboard Pemohon')

@section('content')

<div class="hero">
    <div>
        <span class="badge-status" style="background:rgba(255,255,255,.18);color:white">
            <i class="bi bi-shield-check"></i>&nbsp; PORTAL RESMI PEMOHON
        </span>

        <h2>Selamat Datang, {{ Auth::user()->name }}!</h2>

        <p>
            Selamat datang di Portal Pemohon Kalender Publikasi Kominfo Kabupaten Ngawi.
            Ajukan kegiatan dan pantau perkembangan pengajuan Anda melalui dashboard ini.
        </p>
    </div>

    <i class="bi bi-calendar2-check hero-icon"></i>
</div>

<div class="page-heading">
    <div class="eyebrow">Ringkasan aktivitas</div>
    <h1 class="page-title">Ringkasan Pengajuan</h1>
    <p class="page-description">
        Pantau status seluruh pengajuan kegiatan yang telah Anda kirimkan.
    </p>
</div>

<div class="stat-grid" style="margin-bottom:28px">
    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background:#fff4d9;color:#a87900">
                <i class="bi bi-clock-history"></i>
            </div>
        </div>
        <div class="stat-number">{{ $menunggu }}</div>
        <div class="stat-label">Menunggu Pemeriksaan</div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background:#e2f5e9;color:#16834b">
                <i class="bi bi-check-circle"></i>
            </div>
        </div>
        <div class="stat-number">{{ $disetujui }}</div>
        <div class="stat-label">Disetujui Administrator</div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background:#e7efff;color:#315db5">
                <i class="bi bi-arrow-repeat"></i>
            </div>
        </div>
        <div class="stat-number">{{ $revisi }}</div>
        <div class="stat-label">Perlu Revisi</div>
    </div>

    <div class="stat-card">
        <div class="stat-top">
            <div class="stat-icon" style="background:#ffebec;color:#bd3442">
                <i class="bi bi-x-circle"></i>
            </div>
        </div>
        <div class="stat-number">{{ $ditolak }}</div>
        <div class="stat-label">Ditolak</div>
    </div>
</div>

<div class="page-heading">
    <div class="eyebrow">Layanan digital</div>
    <h2 class="section-title">Layanan Pemohon</h2>
</div>

<div class="action-grid" style="margin-bottom:28px">
    <div class="action-card">
        <div class="action-icon">
            <i class="bi bi-plus-circle"></i>
        </div>
        <h3>Ajukan Kegiatan Baru</h3>
        <p>
            Isi formulir pengajuan kegiatan agar dapat diperiksa
            oleh Administrator Kominfo Kabupaten Ngawi.
        </p>
        <a href="{{ route('pemohon.submissions.create') }}" class="btn btn-primary">
            <i class="bi bi-plus-lg"></i> Buat Pengajuan
        </a>
    </div>

    <div class="action-card">
        <div class="action-icon">
            <i class="bi bi-clipboard-check"></i>
        </div>
        <h3>Riwayat Pengajuan Saya</h3>
        <p>
            Lihat seluruh pengajuan, pantau status pemeriksaan,
            dan baca catatan dari Administrator.
        </p>
        <a href="{{ route('pemohon.submissions.index') }}" class="btn btn-outline">
            <i class="bi bi-list-ul"></i> Lihat Riwayat
        </a>
    </div>
</div>

<div class="panel">
    <div style="display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:18px">
        <div>
            <h2 class="panel-heading">Pengajuan Terbaru</h2>
            <p class="panel-description" style="margin:5px 0 0">
                Lima pengajuan terbaru yang telah Anda kirimkan.
            </p>
        </div>

        <a href="{{ route('pemohon.submissions.index') }}" class="btn btn-secondary">
            Lihat Semua <i class="bi bi-arrow-right"></i>
        </a>
    </div>

    @if($pengajuanTerbaru->count() > 0)
        <div class="table-wrap">
            <table class="data-table" style="min-width:550px">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nama Kegiatan</th>
                        <th>Tanggal</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pengajuanTerbaru as $index => $pengajuan)
                        @php
                            $status = strtolower(trim($pengajuan->status));
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
                            <td>{{ $index + 1 }}</td>
                            <td>
                                <strong>{{ $pengajuan->title }}</strong>
                            </td>
                            <td>
                                {{ $pengajuan->activity_date
                                    ? $pengajuan->activity_date->format('d-m-Y')
                                    : '-' }}
                            </td>
                            <td>
                                <span class="badge-status {{ $statusClass }}">
                                    {{ $pengajuan->status }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @else
        <div class="empty-state">
            <i class="bi bi-inbox"></i>
            <h3>Belum Ada Pengajuan</h3>
            <p>Pengajuan kegiatan yang Anda kirimkan akan tampil di bagian ini.</p>
            <a href="{{ route('pemohon.submissions.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-lg"></i> Buat Pengajuan Pertama
            </a>
        </div>
    @endif
</div>

@endsection
