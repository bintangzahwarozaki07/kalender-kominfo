<nav class="navbar navbar-expand-lg navbar-dark bg-primary shadow">
    <div class="container-fluid">

        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">
            📅 Kalender Publikasi Kominfo
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
                    <a class="nav-link" href="#">
                        Instansi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Kalender Publikasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Dokumentasi
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link" href="#">
                        Link Publikasi
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