
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="app-url" content="{{ url('/') }}">

    <meta name="theme-color" content="#064e3b">

    <title>@yield('title', 'SIPKP | Kominfo Ngawi')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>

        /* =====================================
           GLOBAL DESIGN
        ===================================== */

        :root {
            --sipkp-primary: #059669;
            --sipkp-dark: #064e3b;
            --sipkp-deep: #022c22;
            --sipkp-light: #d1fae5;
            --sipkp-bg: #f5f8f7;
            --sipkp-text: #1e293b;
            --sipkp-muted: #94a3b8;
            --sipkp-border: #e8eeeb;
            --sipkp-sidebar-width: 265px;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            background: var(--sipkp-bg);
            color: var(--sipkp-text);
            font-family: Inter, "Segoe UI", Arial, sans-serif;
            font-size: 14px;
        }

        a {
            text-decoration: none;
        }

        /* =====================================
           MAIN WRAPPER
        ===================================== */

        .sipkp-wrapper {
            min-height: 100vh;
        }

        /* =====================================
           SIDEBAR
        ===================================== */

        .sipkp-sidebar {
            width: var(--sipkp-sidebar-width);
            min-height: 100vh;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            z-index: 1050;
            background: linear-gradient(
                180deg,
                #064e3b 0%,
                #043c30 55%,
                #022c22 100%
            );
            color: white;
            overflow-y: auto;
            transition: transform .3s ease;
            scrollbar-width: thin;
            scrollbar-color: rgba(255,255,255,.2) transparent;
        }

        .sipkp-brand {
            min-height: 105px;
            padding: 23px 22px;
            display: flex;
            align-items: center;
            gap: 13px;
            border-bottom: 1px solid rgba(255,255,255,.1);
        }

        .sipkp-brand-icon {
            width: 48px;
            height: 48px;
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 15px;
            background: rgba(255,255,255,.13);
            color: #a7f3d0;
            font-size: 25px;
        }

        .sipkp-brand h4 {
            margin: 0;
            font-size: 19px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: white;
        }

        .sipkp-brand small {
            color: #a7cbbd;
            font-size: 11px;
        }

        .sipkp-sidebar-content {
            padding: 17px 13px 25px;
        }

        .sipkp-section {
            padding: 18px 12px 9px;
            color: #8eb8a8;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .sipkp-menu {
            display: flex;
            align-items: center;
            gap: 13px;
            min-height: 46px;
            padding: 11px 13px;
            margin-bottom: 5px;
            border-radius: 11px;
            color: #d1e4dc;
            font-size: 13px;
            font-weight: 500;
            transition: all .2s ease;
        }

        .sipkp-menu i {
            width: 20px;
            text-align: center;
            font-size: 17px;
            color: #a7cbbd;
        }

        .sipkp-menu:hover {
            color: white;
            background: rgba(255,255,255,.09);
            transform: translateX(3px);
        }

        .sipkp-menu:hover i {
            color: #a7f3d0;
        }

        .sipkp-menu.active {
            color: white;
            background: linear-gradient(
                100deg,
                #059669,
                #047857
            );
            box-shadow: 0 5px 15px rgba(0,0,0,.15);
            font-weight: 700;
        }

        .sipkp-menu.active i {
            color: white;
        }

        .sipkp-sidebar-footer {
            margin: 25px 5px 5px;
            padding: 15px;
            border-radius: 13px;
            background: rgba(255,255,255,.07);
            border: 1px solid rgba(255,255,255,.08);
        }

        .sipkp-sidebar-footer strong {
            display: block;
            color: white;
            font-size: 12px;
            margin-bottom: 4px;
        }

        .sipkp-sidebar-footer small {
            color: #a7cbbd;
            font-size: 10px;
            line-height: 1.6;
        }

        /* =====================================
           MAIN AREA
        ===================================== */

        .sipkp-main {
            margin-left: var(--sipkp-sidebar-width);
            min-height: 100vh;
            transition: margin .3s ease;
        }

        /* =====================================
           TOPBAR
        ===================================== */

        .sipkp-topbar {
            height: 76px;
            padding: 0 30px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: rgba(255,255,255,.95);
            border-bottom: 1px solid var(--sipkp-border);
            position: sticky;
            top: 0;
            z-index: 1000;
            backdrop-filter: blur(12px);
        }

        .sipkp-topbar-left {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .sipkp-page-heading {
            margin: 0;
            font-size: 17px;
            font-weight: 750;
            color: #173b32;
        }

        .sipkp-breadcrumb {
            margin-top: 3px;
            color: #94a3b8;
            font-size: 11px;
        }

        .sipkp-topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .sipkp-admin-profile {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 7px 12px;
            border: 1px solid var(--sipkp-border);
            border-radius: 12px;
            background: #fff;
        }

        .sipkp-avatar {
            width: 36px;
            height: 36px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--sipkp-light);
            color: var(--sipkp-dark);
            font-size: 17px;
        }

        .sipkp-profile-name {
            color: #1e293b;
            font-size: 12px;
            font-weight: 750;
        }

        .sipkp-profile-role {
            display: block;
            color: #94a3b8;
            font-size: 10px;
        }

        .sipkp-logout {
            border: none;
            padding: 10px 14px;
            border-radius: 10px;
            background: #fff1f2;
            color: #e11d48;
            font-size: 12px;
            font-weight: 700;
            transition: .2s;
        }

        .sipkp-logout:hover {
            background: #ffe4e6;
            color: #be123c;
        }

        .sipkp-mobile-toggle {
            display: none;
            width: 39px;
            height: 39px;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--sipkp-border);
            border-radius: 10px;
            background: white;
            color: var(--sipkp-dark);
            font-size: 20px;
        }

        /* =====================================
           CONTENT
        ===================================== */

        .sipkp-content {
            padding: 30px;
            min-height: calc(100vh - 76px);
        }

        .sipkp-content .card {
            border: 1px solid var(--sipkp-border);
            border-radius: 15px;
            box-shadow: 0 4px 18px rgba(15, 40, 30, .035);
        }

        .sipkp-content .card-header {
            border-radius: 15px 15px 0 0;
        }

        .sipkp-content .btn {
            border-radius: 9px;
            font-weight: 600;
            transition: .2s;
        }

        .sipkp-content .form-control,
        .sipkp-content .form-select {
            border-radius: 9px;
            border-color: #dfe8e3;
            padding: 10px 12px;
        }

        .sipkp-content .form-control:focus,
        .sipkp-content .form-select:focus {
            border-color: #34d399;
            box-shadow: 0 0 0 .2rem rgba(16,185,129,.12);
        }

        .sipkp-content .table {
            vertical-align: middle;
        }

        .sipkp-content .table thead th {
            color: #64748b;
            background: #f8faf9;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: .4px;
            padding: 14px;
        }

        .sipkp-content .table tbody td {
            padding: 13px 14px;
            font-size: 13px;
        }

        /* =====================================
           SIDEBAR OVERLAY
        ===================================== */

        .sipkp-overlay {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 1040;
            background: rgba(2, 20, 14, .55);
            backdrop-filter: blur(2px);
        }

        /* =====================================
           RESPONSIVE
        ===================================== */

        @media (max-width: 991.98px) {

            .sipkp-sidebar {
                transform: translateX(-100%);
            }

            body.sipkp-sidebar-open .sipkp-sidebar {
                transform: translateX(0);
            }

            body.sipkp-sidebar-open .sipkp-overlay {
                display: block;
            }

            .sipkp-main {
                margin-left: 0;
            }

            .sipkp-mobile-toggle {
                display: flex;
            }

            .sipkp-content {
                padding: 22px;
            }

            .sipkp-topbar {
                padding: 0 20px;
            }

        }

        @media (max-width: 575.98px) {

            .sipkp-topbar {
                height: 68px;
                padding: 0 13px;
            }

            .sipkp-page-heading {
                font-size: 14px;
            }

            .sipkp-breadcrumb {
                display: none;
            }

            .sipkp-content {
                padding: 15px;
            }

            .sipkp-admin-profile {
                padding: 5px;
                border: none;
            }

            .sipkp-profile-info {
                display: none;
            }

            .sipkp-avatar {
                width: 34px;
                height: 34px;
            }

            .sipkp-logout {
                padding: 9px 10px;
                font-size: 11px;
            }

            .sipkp-logout span {
                display: none;
            }

        }

    </style>

</head>

<body>

<div class="sipkp-wrapper">

    {{-- SIDEBAR --}}
    <aside class="sipkp-sidebar" id="sipkpSidebar">

        <div class="sipkp-brand">

            <div class="sipkp-brand-icon">
                <i class="bi bi-calendar2-check-fill"></i>
            </div>

            <div>
                <h4>SIPKP</h4>
                <small>Kominfo Kabupaten Ngawi</small>
            </div>

        </div>

        <div class="sipkp-sidebar-content">

            <div class="sipkp-section">
                Menu Utama
            </div>

            <a href="{{ route('dashboard') }}"
               class="sipkp-menu {{ request()->routeIs('dashboard') ? 'active' : '' }}">

                <i class="bi bi-grid-1x2-fill"></i>
                <span>Dashboard</span>

            </a>

            <div class="sipkp-section">
                Master Data
            </div>

            <a href="{{ route('categories.index') }}"
               class="sipkp-menu {{ request()->routeIs('categories.*') ? 'active' : '' }}">

                <i class="bi bi-collection-fill"></i>
                <span>Kategori</span>

            </a>

            <a href="{{ route('institutions.index') }}"
               class="sipkp-menu {{ request()->routeIs('institutions.*') ? 'active' : '' }}">

                <i class="bi bi-buildings-fill"></i>
                <span>Instansi</span>

            </a>

            <div class="sipkp-section">
                Manajemen Kegiatan
            </div>

            <a href="{{ route('activities.index') }}"
               class="sipkp-menu {{ request()->routeIs('activities.*') ? 'active' : '' }}">

                <i class="bi bi-calendar-event-fill"></i>
                <span>Kegiatan</span>

            </a>

            <a href="{{ route('admin.submissions.index') }}"
               class="sipkp-menu {{ request()->routeIs('admin.submissions.*') ? 'active' : '' }}">

                <i class="bi bi-inbox-fill"></i>
                <span>Pengajuan Pemohon</span>

            </a>

            <a href="{{ route('documentations.index') }}"
               class="sipkp-menu {{ request()->routeIs('documentations.*') ? 'active' : '' }}">

                <i class="bi bi-images"></i>
                <span>Dokumentasi</span>

            </a>

            <div class="sipkp-sidebar-footer">

                <strong>
                    <i class="bi bi-shield-check me-1"></i>
                    SIPKP Kominfo
                </strong>

                <small>
                    Sistem Informasi Kalender Publikasi dan Manajemen Dokumentasi Kegiatan.
                </small>

            </div>

        </div>

    </aside>


    {{-- MOBILE OVERLAY --}}
    <div class="sipkp-overlay" id="sipkpOverlay"></div>


    {{-- MAIN CONTENT --}}
    <main class="sipkp-main">

        {{-- TOPBAR --}}
        <header class="sipkp-topbar">

            <div class="sipkp-topbar-left">

                <button type="button"
                        class="sipkp-mobile-toggle"
                        id="sipkpMenuToggle"
                        aria-label="Buka navigasi">

                    <i class="bi bi-list"></i>

                </button>

                <div>

                    <h1 class="sipkp-page-heading">
                        @yield('page-title', 'Sistem Informasi Kalender Publikasi')
                    </h1>

                    <div class="sipkp-breadcrumb">
                        Kominfo Kabupaten Ngawi / Area Administrator
                    </div>

                </div>

            </div>


            <div class="sipkp-topbar-right">

                <div class="sipkp-admin-profile">

                    <div class="sipkp-avatar">
                        <i class="bi bi-person-fill"></i>
                    </div>

                    <div class="sipkp-profile-info">

                        <div class="sipkp-profile-name">
                            {{ Auth::user()->name }}
                        </div>

                        <span class="sipkp-profile-role">
                            Administrator
                        </span>

                    </div>

                </div>


                <form action="{{ route('logout') }}" method="POST">
                    @csrf

                    <button type="submit" class="sipkp-logout">

                        <i class="bi bi-box-arrow-right me-1"></i>
                        <span>Logout</span>

                    </button>

                </form>

            </div>

        </header>


        {{-- PAGE CONTENT --}}
        <section class="sipkp-content">

            @yield('content')

        </section>

    </main>

</div>


{{-- NOTIFIKASI BERHASIL --}}
@if(session('success'))

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (window.Swal) {

        Swal.fire({
            icon: 'success',
            title: 'Berhasil',
            text: @json(session('success')),
            timer: 2500,
            showConfirmButton: false,
            confirmButtonColor: '#059669'
        });

    }

});
</script>

@endif


{{-- NOTIFIKASI ERROR --}}
@if($errors->any())

<script>
document.addEventListener('DOMContentLoaded', function () {

    if (window.Swal) {

        Swal.fire({
            icon: 'error',
            title: 'Terjadi Kesalahan',
            text: @json($errors->first()),
            confirmButtonText: 'Mengerti',
            confirmButtonColor: '#059669'
        });

    }

});
</script>

@endif


{{-- KONFIRMASI HAPUS --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

    document.querySelectorAll('.delete-confirm').forEach(function (btn) {

        btn.addEventListener('click', function (e) {

            e.preventDefault();

            const form = this.closest('form');

            if (!form || !window.Swal) {
                return;
            }

            Swal.fire({

                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',

                showCancelButton: true,

                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',

                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#64748b',

                reverseButtons: true

            }).then((result) => {

                if (result.isConfirmed) {
                    form.submit();
                }

            });

        });

    });


    // =====================================
    // MOBILE SIDEBAR
    // =====================================

    const menuToggle = document.getElementById('sipkpMenuToggle');
    const overlay = document.getElementById('sipkpOverlay');

    function closeSidebar() {
        document.body.classList.remove('sipkp-sidebar-open');
    }

    if (menuToggle) {

        menuToggle.addEventListener('click', function () {

            document.body.classList.toggle('sipkp-sidebar-open');

        });

    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    document.querySelectorAll('.sipkp-menu').forEach(function (menu) {

        menu.addEventListener('click', function () {

            if (window.innerWidth < 992) {
                closeSidebar();
            }

        });

    });

    document.addEventListener('keydown', function (e) {

        if (e.key === 'Escape') {
            closeSidebar();
        }

    });

});
</script>


@stack('scripts')

</body>
</html>
