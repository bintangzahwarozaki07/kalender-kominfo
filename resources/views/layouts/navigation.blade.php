<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            <i class="bi bi-calendar-event me-2"></i>
            Kalender Publikasi Kominfo
        </a>

        <button class="navbar-toggler"
                type="button"
                data-bs-toggle="collapse"
                data-bs-target="#navbarNav">

            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">

            <ul class="navbar-nav me-auto">

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('dashboard') }}">
                        Dashboard
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('categories.index') }}">
                        Kategori
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('institutions.index') }}">
                        Instansi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('activities.index') }}">
                        Kegiatan
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="{{ route('documentations.index') }}">
                        <i class="bi bi-images me-1"></i>
                        Dokumentasi
                    </a>
                </li>

            </ul>

            <ul class="navbar-nav">

                <li class="nav-item me-3 mt-2 text-white">
                    {{ Auth::user()->name }}
                </li>

                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf

                        <button class="btn btn-danger btn-sm">
                            Logout
                        </button>
                    </form>
                </li>

            </ul>

        </div>
    </div>
</nav>