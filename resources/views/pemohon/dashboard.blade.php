
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Dashboard Pemohon - Kalender Publikasi Kominfo Ngawi</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
          rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"
          rel="stylesheet">

    <style>
        body {
            background: #f4f7f5;
            font-family: Arial, sans-serif;
            color: #263b32;
        }

        .navbar-custom {
            background: #075b43;
            padding: 16px 0;
        }

        .brand {
            color: white;
            font-weight: bold;
            font-size: 20px;
        }

        .hero {
            background: linear-gradient(135deg, #075b43, #11966b);
            color: white;
            border-radius: 18px;
            padding: 30px;
            margin-top: 28px;
        }

        .stat-card {
            background: white;
            border: none;
            border-radius: 15px;
            padding: 22px;
            height: 100%;
            box-shadow: 0 3px 15px rgba(0,0,0,.04);
        }

        .stat-icon {
            font-size: 25px;
            margin-bottom: 12px;
        }

        .stat-number {
            font-size: 30px;
            font-weight: bold;
        }

        .action-card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            height: 100%;
            border: 1px solid #e7eee9;
        }

        .action-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            background: #e5f4ed;
            color: #087f5b;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 23px;
        }

        .btn-green {
            background: #087f5b;
            color: white;
            border: none;
        }

        .btn-green:hover {
            background: #075b43;
            color: white;
        }

        .table-card {
            background: white;
            border-radius: 15px;
            padding: 22px;
            box-shadow: 0 3px 15px rgba(0,0,0,.04);
        }

        .status {
            padding: 6px 11px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
            display: inline-block;
        }

        .status-menunggu {
            background: #fff3cd;
            color: #856404;
        }

        .status-disetujui {
            background: #d1e7dd;
            color: #0f5132;
        }

        .status-ditolak {
            background: #f8d7da;
            color: #842029;
        }

        .status-revisi {
            background: #cfe2ff;
            color: #084298;
        }

        footer {
            color: #78877f;
            padding: 25px 0;
            text-align: center;
            font-size: 13px;
        }
    </style>
</head>

<body>

{{-- NAVBAR --}}
<nav class="navbar-custom">
    <div class="container d-flex justify-content-between align-items-center">

        <div class="brand">
            <i class="bi bi-calendar2-week me-2"></i>
            SIPKP Kominfo Ngawi
        </div>

        <form action="{{ route('logout') }}" method="POST">
            @csrf

            <button type="submit" class="btn btn-outline-light btn-sm">
                <i class="bi bi-box-arrow-right me-1"></i>
                Logout
            </button>
        </form>

    </div>
</nav>

<div class="container pb-4">

    {{-- SAMBUTAN --}}
    <div class="hero">

        <div class="row align-items-center">

            <div class="col-md-8">

                <span class="badge bg-light text-success mb-3">
                    PORTAL PENGAJUAN KEGIATAN
                </span>

                <h2 class="fw-bold">
                    Selamat Datang, {{ Auth::user()->name }}!
                </h2>

                <p class="mb-0">
                    Selamat datang di Portal Pemohon Kalender Publikasi
                    Kominfo Kabupaten Ngawi. Ajukan kegiatan dan pantau
                    perkembangan pengajuan Anda melalui dashboard ini.
                </p>

            </div>

            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                <i class="bi bi-calendar-check"
                   style="font-size: 85px; opacity: .8;"></i>
            </div>

        </div>

    </div>

    {{-- STATISTIK --}}
    <div class="mt-4">

        <h5 class="fw-bold mb-3">Ringkasan Pengajuan</h5>

        <div class="row g-3">

            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon text-warning">
                        <i class="bi bi-clock-history"></i>
                    </div>

                    <div class="stat-number">
                        {{ $menunggu }}
                    </div>

                    <div class="text-muted small">
                        Menunggu Pemeriksaan
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon text-success">
                        <i class="bi bi-check-circle"></i>
                    </div>

                    <div class="stat-number">
                        {{ $disetujui }}
                    </div>

                    <div class="text-muted small">
                        Disetujui
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon text-primary">
                        <i class="bi bi-arrow-repeat"></i>
                    </div>

                    <div class="stat-number">
                        {{ $revisi }}
                    </div>

                    <div class="text-muted small">
                        Perlu Revisi
                    </div>
                </div>
            </div>

            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <div class="stat-icon text-danger">
                        <i class="bi bi-x-circle"></i>
                    </div>

                    <div class="stat-number">
                        {{ $ditolak }}
                    </div>

                    <div class="text-muted small">
                        Ditolak
                    </div>
                </div>
            </div>

        </div>
    </div>

    {{-- MENU --}}
    <div class="mt-4">

        <h5 class="fw-bold mb-3">Layanan Pemohon</h5>

        <div class="row g-3">

            <div class="col-md-6">

                <div class="action-card">

                    <div class="action-icon mb-3">
                        <i class="bi bi-plus-circle"></i>
                    </div>

                    <h5 class="fw-bold">Ajukan Kegiatan Baru</h5>

                    <p class="text-muted small">
                        Isi formulir pengajuan kegiatan untuk
                        diperiksa oleh Administrator Kominfo Ngawi.
                    </p>

                    <a href="{{ route('pemohon.submissions.create') }}"
                       class="btn btn-green">

                        <i class="bi bi-plus-lg me-1"></i>
                        Buat Pengajuan

                    </a>

                </div>

            </div>

            <div class="col-md-6">

                <div class="action-card">

                    <div class="action-icon mb-3">
                        <i class="bi bi-clipboard-check"></i>
                    </div>

                    <h5 class="fw-bold">Riwayat Pengajuan Saya</h5>

                    <p class="text-muted small">
                        Lihat seluruh pengajuan kegiatan dan
                        periksa status serta catatan dari Administrator.
                    </p>

                    <a href="{{ route('pemohon.submissions.index') }}"
                       class="btn btn-outline-success">

                        <i class="bi bi-list-ul me-1"></i>
                        Lihat Pengajuan

                    </a>

                </div>

            </div>

        </div>

    </div>

    {{-- PENGAJUAN TERBARU --}}
    <div class="table-card mt-4">

        <div class="d-flex justify-content-between align-items-center mb-3">

            <h5 class="fw-bold mb-0">
                Pengajuan Terbaru
            </h5>

            <a href="{{ route('pemohon.submissions.index') }}"
               class="text-success text-decoration-none small">
                Lihat Semua
                <i class="bi bi-arrow-right"></i>
            </a>

        </div>

        @if($pengajuanTerbaru->count() > 0)

            <div class="table-responsive">

                <table class="table table-hover align-middle">

                    <thead class="table-light">
                        <tr>
                            <th>No.</th>
                            <th>Nama Kegiatan</th>
                            <th>Tanggal</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>

                        @foreach($pengajuanTerbaru as $index => $pengajuan)

                            <tr>

                                <td>{{ $index + 1 }}</td>

                                <td>
                                    <strong>
                                        {{ $pengajuan->title }}
                                    </strong>
                                </td>

                                <td>
                                    {{ $pengajuan->activity_date->format('d-m-Y') }}
                                </td>

                                <td>

                                    @if($pengajuan->status === 'Menunggu')
                                        <span class="status status-menunggu">
                                            Menunggu
                                        </span>

                                    @elseif($pengajuan->status === 'Disetujui')
                                        <span class="status status-disetujui">
                                            Disetujui
                                        </span>

                                    @elseif($pengajuan->status === 'Ditolak')
                                        <span class="status status-ditolak">
                                            Ditolak
                                        </span>

                                    @elseif($pengajuan->status === 'Perlu Revisi')
                                        <span class="status status-revisi">
                                            Perlu Revisi
                                        </span>

                                    @else
                                        <span class="badge bg-secondary">
                                            {{ $pengajuan->status }}
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        @else

            <div class="text-center py-5">

                <i class="bi bi-inbox text-muted"
                   style="font-size: 45px;"></i>

                <p class="text-muted mt-2 mb-0">
                    Belum ada pengajuan kegiatan.
                </p>

            </div>

        @endif

    </div>

    <footer>
        Sistem Informasi Kalender Publikasi dan Manajemen Dokumentasi
        Kegiatan Dinas Statistik, Komunikasi, Informatika dan Persandian
        Kabupaten Ngawi
        <br>
        &copy; {{ date('Y') }} Kominfo Kabupaten Ngawi
    </footer>

</div>

</body>
</html>
