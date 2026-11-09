<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Sistem Informasi Kalender Publikasi')</title>

    @vite([
        'resources/css/app.css',
        'resources/js/app.js'
    ])

    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-light">

<div class="container-fluid">
    <div class="row min-vh-100">

        {{-- Sidebar --}}
        <nav class="col-lg-2 col-md-3 bg-dark p-0">

            <div class="text-center text-white py-4 border-bottom">
                <h3 class="mb-0">SIPKP</h3>
                <small>Kominfo Ngawi</small>
            </div>

            <div class="list-group list-group-flush rounded-0">

                <a href="{{ route('dashboard') }}"
                   class="list-group-item list-group-item-action">
                    <i class="bi bi-speedometer2 me-2"></i>
                    Dashboard
                </a>

                <a href="{{ route('categories.index') }}"
                   class="list-group-item list-group-item-action">
                    <i class="bi bi-folder me-2"></i>
                    Kategori
                </a>

                <a href="{{ route('institutions.index') }}"
                   class="list-group-item list-group-item-action">
                    <i class="bi bi-building me-2"></i>
                    Instansi
                </a>

                <a href="{{ route('activities.index') }}"
                   class="list-group-item list-group-item-action">
                    <i class="bi bi-calendar-event me-2"></i>
                    Kegiatan
                </a>

                <a href="{{ route('documentations.index') }}"
                   class="list-group-item list-group-item-action">
                    <i class="bi bi-images me-2"></i>
                    Dokumentasi
                </a>

            </div>
        </nav>

        {{-- Content --}}
        <main class="col-lg-10 col-md-9 p-0">

            <nav class="navbar navbar-expand-lg navbar-light bg-white shadow-sm">
                <div class="container-fluid">

                    <span class="navbar-brand fw-bold">
                        Sistem Informasi Kalender Publikasi
                    </span>

                    <div class="ms-auto d-flex align-items-center">

                        <span class="me-3 fw-semibold">
                            {{ Auth::user()->name }}
                        </span>

                        <form action="{{ route('logout') }}" method="POST">
                            @csrf

                            <button class="btn btn-danger btn-sm">
                                <i class="bi bi-box-arrow-right me-1"></i>
                                Logout
                            </button>
                        </form>

                    </div>
                </div>
            </nav>

            <div class="p-4">
                @yield('content')
            </div>

        </main>

    </div>
</div>

{{-- Notifikasi berhasil --}}
@if(session('success'))
<script>
document.addEventListener('DOMContentLoaded', function () {
    Swal.fire({
        icon: 'success',
        title: 'Berhasil',
        text: @json(session('success')),
        timer: 2000,
        showConfirmButton: false
    });
});
</script>
@endif

{{-- Konfirmasi hapus --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    document.querySelectorAll('.delete-confirm').forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();

            const form = this.closest('form');

            Swal.fire({
                title: 'Yakin ingin menghapus?',
                text: 'Data yang dihapus tidak dapat dikembalikan.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus',
                cancelButtonText: 'Batal',
                confirmButtonColor: '#dc3545'
            }).then((result) => {
                if (result.isConfirmed && form) {
                    form.submit();
                }
            });
        });
    });
});
</script>

@stack('scripts')

</body>
</html>