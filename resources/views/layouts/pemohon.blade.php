
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#087f5b">

    <title>@yield('title', 'Portal Pemohon') - SIPKP Kominfo Ngawi</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        :root {
            --green: #087f5b;
            --green-dark: #075b43;
            --green-light: #e8f5ef;
            --background: #f5f8f6;
            --text: #24352d;
            --muted: #738078;
            --border: #e6ece8;
            --white: #ffffff;
            --shadow: 0 8px 28px rgba(25, 55, 40, .055);
        }

        * { box-sizing: border-box; }

        body {
            margin: 0;
            background: var(--background);
            color: var(--text);
            font-family: 'Inter', Arial, sans-serif;
            font-size: 14px;
        }

        a { color: inherit; }

        .topbar {
            background: var(--white);
            border-bottom: 1px solid var(--border);
            position: sticky;
            top: 0;
            z-index: 20;
        }

        .topbar-inner {
            max-width: 1240px;
            min-height: 76px;
            margin: auto;
            padding: 12px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
        }

        .brand-icon {
            width: 44px;
            height: 44px;
            border-radius: 13px;
            background: var(--green-light);
            color: var(--green);
            display: grid;
            place-items: center;
            font-size: 23px;
        }

        .brand-name {
            font-size: 15px;
            font-weight: 800;
            color: var(--green-dark);
            letter-spacing: -.3px;
        }

        .brand-subtitle {
            margin-top: 4px;
            color: var(--muted);
            font-size: 11px;
        }

        .topbar-right {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-info {
            text-align: right;
        }

        .user-name {
            font-size: 13px;
            font-weight: 700;
        }

        .user-role {
            font-size: 11px;
            color: var(--muted);
            margin-top: 3px;
        }

        .avatar {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: var(--green-light);
            color: var(--green-dark);
            font-weight: 800;
        }

        .logout-form { margin: 0; }

        .main-nav {
            background: white;
            border-bottom: 1px solid var(--border);
        }

        .nav-inner {
            max-width: 1240px;
            margin: auto;
            padding: 0 24px;
            display: flex;
            gap: 8px;
            overflow-x: auto;
        }

        .nav-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 15px 14px;
            text-decoration: none;
            color: #68766e;
            font-size: 13px;
            font-weight: 600;
            white-space: nowrap;
            border-bottom: 3px solid transparent;
        }

        .nav-link:hover,
        .nav-link.active {
            color: var(--green);
        }

        .nav-link.active {
            border-bottom-color: var(--green);
        }

        .page-container {
            width: min(1240px, 100%);
            margin: 30px auto;
            padding: 0 24px;
            min-height: 65vh;
        }

        .page-heading {
            margin-bottom: 24px;
        }

        .eyebrow {
            color: var(--green);
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-bottom: 9px;
        }

        .page-title {
            font-size: clamp(23px, 3vw, 29px);
            line-height: 1.3;
            letter-spacing: -.8px;
            color: #193b2d;
            font-weight: 800;
            margin: 0;
        }

        .page-description {
            color: var(--muted);
            line-height: 1.7;
            margin: 9px 0 0;
            max-width: 760px;
        }

        .panel {
            background: var(--white);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 24px;
            box-shadow: var(--shadow);
        }

        .panel-heading {
            font-size: 16px;
            font-weight: 800;
            margin: 0 0 5px;
            color: #244332;
        }

        .panel-description {
            color: var(--muted);
            font-size: 12px;
            line-height: 1.6;
            margin: 0 0 20px;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            border: 1px solid transparent;
            border-radius: 9px;
            font-family: inherit;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: .2s ease;
        }

        .btn-primary {
            background: var(--green);
            color: white;
        }

        .btn-primary:hover {
            background: var(--green-dark);
            color: white;
            transform: translateY(-1px);
        }

        .btn-secondary {
            background: #f0f4f1;
            border-color: var(--border);
            color: #42564a;
        }

        .btn-secondary:hover { background: #e5ece7; }

        .btn-outline {
            background: white;
            border-color: #cfe1d6;
            color: var(--green);
        }

        .btn-outline:hover { background: var(--green-light); }

        .btn-warning {
            background: #fff5d9;
            color: #8a6500;
        }

        .btn-danger {
            background: #fff0f0;
            color: #b42332;
        }

        .alert {
            padding: 14px 16px;
            border-radius: 10px;
            margin-bottom: 18px;
            line-height: 1.6;
        }

        .alert-success {
            background: #e8f6ed;
            border: 1px solid #c9e9d3;
            color: #17663b;
        }

        .alert-danger {
            background: #fff0f0;
            border: 1px solid #f4cccc;
            color: #a52834;
        }

        .alert-warning {
            background: #fff8e5;
            border: 1px solid #f1dfaa;
            color: #775800;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 18px;
        }

        .form-group { margin-bottom: 18px; }

        .form-label {
            display: block;
            color: #34483c;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 8px;
        }

        .required { color: #dc3545; }

        .form-control {
            display: block;
            width: 100%;
            min-height: 44px;
            padding: 11px 13px;
            border: 1px solid #dce5df;
            border-radius: 9px;
            background: white;
            color: var(--text);
            font-family: inherit;
            font-size: 13px;
            outline: none;
            transition: .2s;
        }

        .form-control:focus {
            border-color: var(--green);
            box-shadow: 0 0 0 3px rgba(8,127,91,.10);
        }

        textarea.form-control {
            min-height: 120px;
            resize: vertical;
        }

        .form-hint {
            color: var(--muted);
            font-size: 11px;
            line-height: 1.6;
            margin-top: 6px;
        }

        .field-error {
            color: #c62838;
            font-size: 11px;
            margin-top: 6px;
        }

        .table-wrap {
            width: 100%;
            overflow-x: auto;
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 780px;
        }

        .data-table th {
            background: #f5f8f6;
            color: #53645a;
            text-align: left;
            padding: 14px 12px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .4px;
            white-space: nowrap;
        }

        .data-table td {
            padding: 15px 12px;
            border-bottom: 1px solid #edf1ee;
            color: #435249;
            font-size: 12px;
            vertical-align: top;
        }

        .data-table tbody tr:hover { background: #fbfdfb; }

        .badge-status {
            display: inline-flex;
            align-items: center;
            padding: 6px 10px;
            border-radius: 30px;
            font-size: 10px;
            font-weight: 800;
            white-space: nowrap;
        }

        .status-menunggu { background: #fff3cd; color: #856404; }
        .status-disetujui { background: #d9f1e2; color: #17663b; }
        .status-ditolak { background: #fce1e3; color: #a52834; }
        .status-revisi { background: #e2edff; color: #2454a6; }

        .stat-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
        }

        .stat-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 20px;
            box-shadow: var(--shadow);
        }

        .stat-top {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .stat-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            font-size: 19px;
        }

        .stat-number {
            font-size: 29px;
            font-weight: 800;
            color: #203d2d;
            letter-spacing: -1px;
        }

        .stat-label {
            color: var(--muted);
            font-size: 11px;
            margin-top: 5px;
            line-height: 1.5;
        }

        .hero {
            padding: 30px;
            color: white;
            border-radius: 18px;
            background: linear-gradient(120deg, #075b43, #0c9569);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 20px;
            overflow: hidden;
            position: relative;
            margin-bottom: 25px;
        }

        .hero h2 {
            font-size: clamp(22px, 3vw, 29px);
            font-weight: 800;
            margin: 12px 0 8px;
        }

        .hero p {
            max-width: 690px;
            line-height: 1.7;
            color: rgba(255,255,255,.86);
            margin: 0;
            font-size: 13px;
        }

        .hero-icon {
            font-size: 85px;
            opacity: .25;
            padding: 0 18px;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .action-card {
            background: white;
            border: 1px solid var(--border);
            border-radius: 15px;
            padding: 22px;
            box-shadow: var(--shadow);
        }

        .action-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            background: var(--green-light);
            color: var(--green);
            border-radius: 13px;
            font-size: 22px;
            margin-bottom: 15px;
        }

        .action-card h3 {
            font-size: 15px;
            margin: 0 0 8px;
            color: #264433;
        }

        .action-card p {
            font-size: 12px;
            line-height: 1.7;
            color: var(--muted);
            margin: 0 0 17px;
        }

        .section-title {
            font-size: 16px;
            font-weight: 800;
            color: #244332;
            margin: 0 0 15px;
        }

        .empty-state {
            text-align: center;
            padding: 42px 15px;
            color: var(--muted);
        }

        .empty-state i {
            font-size: 42px;
            color: #a8b8ad;
        }

        .empty-state h3 {
            font-size: 15px;
            color: #34483c;
            margin: 12px 0 6px;
        }

        .note-box {
            max-width: 240px;
            padding: 10px;
            border-radius: 8px;
            background: #fff8e5;
            color: #775800;
            line-height: 1.6;
            font-size: 11px;
        }

        .pagination {
            margin-top: 20px;
        }

        .pagination nav > div:first-child {
            display: none;
        }

        .pagination nav > div:last-child > span,
        .pagination nav > div:last-child > a {
            display: inline-flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .pagination a,
        .pagination span[aria-current="page"] span,
        .pagination span[aria-disabled="true"] span {
            display: inline-block;
            padding: 8px 12px;
            border-radius: 7px;
            background: #f0f5f1;
            color: #315b43;
            text-decoration: none;
            font-size: 12px;
            margin-right: 4px;
        }

        .pagination span[aria-current="page"] span {
            background: var(--green);
            color: white;
        }

        .footer {
            border-top: 1px solid var(--border);
            background: white;
            text-align: center;
            color: var(--muted);
            font-size: 11px;
            line-height: 1.8;
            padding: 23px 15px;
        }

        .inline-actions {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 8px;
        }

        @media (max-width: 800px) {
            .stat-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
        }

        @media (max-width: 600px) {
            .topbar-inner { padding: 11px 15px; }
            .nav-inner { padding: 0 12px; }
            .page-container { padding: 0 15px; margin: 22px auto; }
            .brand-name { font-size: 13px; }
            .brand-subtitle { font-size: 10px; }
            .user-info { display: none; }
            .hero { padding: 23px; }
            .hero-icon { display: none; }
            .stat-grid { gap: 10px; }
            .stat-card { padding: 15px; }
            .stat-number { font-size: 25px; }
            .action-grid, .form-grid { grid-template-columns: 1fr; gap: 0; }
            .panel { padding: 18px; }
        }
    </style>

    @stack('styles')
</head>
<body>

<header class="topbar">
    <div class="topbar-inner">
        <a href="{{ route('pemohon.dashboard') }}" class="brand">
            <span class="brand-icon"><i class="bi bi-calendar2-week"></i></span>
            <span>
                <span class="brand-name">SIPKP KOMINFO NGAWI</span>
                <span class="brand-subtitle" style="display:block">Portal Pengajuan Kegiatan</span>
            </span>
        </a>

        <div class="topbar-right">
            <div class="user-info">
                <div class="user-name">{{ Auth::user()->name }}</div>
                <div class="user-role">Akun Pemohon</div>
            </div>

            <div class="avatar">
                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
            </div>

            <form action="{{ route('logout') }}" method="POST" class="logout-form">
                @csrf
                <button type="submit" class="btn btn-secondary">
                    <i class="bi bi-box-arrow-right"></i>
                    <span>Keluar</span>
                </button>
            </form>
        </div>
    </div>
</header>

<nav class="main-nav">
    <div class="nav-inner">
        <a href="{{ route('pemohon.dashboard') }}"
           class="nav-link {{ request()->routeIs('pemohon.dashboard') ? 'active' : '' }}">
            <i class="bi bi-grid"></i> Dashboard
        </a>

        <a href="{{ route('pemohon.submissions.create') }}"
           class="nav-link {{ request()->routeIs('pemohon.submissions.create') ? 'active' : '' }}">
            <i class="bi bi-plus-circle"></i> Buat Pengajuan
        </a>

        <a href="{{ route('pemohon.submissions.index') }}"
           class="nav-link {{ request()->routeIs('pemohon.submissions.index', 'pemohon.submissions.edit') ? 'active' : '' }}">
            <i class="bi bi-clipboard-check"></i> Riwayat Pengajuan
        </a>
    </div>
</nav>

<main class="page-container">
    @yield('content')
</main>

<footer class="footer">
    <strong>Dinas Statistik, Komunikasi, Informatika dan Persandian Kabupaten Ngawi</strong>
    <br>
    Sistem Informasi Kalender Publikasi dan Manajemen Dokumentasi Kegiatan
    <br>
    &copy; {{ date('Y') }} Kominfo Kabupaten Ngawi
</footer>

</body>
</html>
