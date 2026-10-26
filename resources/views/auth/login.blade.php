<x-guest-layout>
<div class="container-fluid min-vh-100 d-flex align-items-center justify-content-center py-5 px-3">
    <div class="row w-100 justify-content-center">
        <div class="col-12 col-sm-10 col-md-7 col-lg-5 col-xl-4">

            <div class="text-center mb-4">
                <div class="calendar-icon mx-auto mb-3">
                    <i class="bi bi-calendar2-check"></i>
                </div>

                <h2 class="fw-bold text-dark mb-2">
                    Kalender Publikasi Ngawi
                </h2>

                <p class="text-secondary mb-0">
                    Sistem Informasi Publikasi dan Dokumentasi Kegiatan
                </p>
            </div>

            <div class="card border-0 shadow-lg rounded-4">
                <div class="card-body p-4 p-md-5">

                    <h4 class="fw-bold mb-2">Selamat Datang</h4>
                    <p class="text-secondary mb-4">
                        Silakan masuk menggunakan akun administrator.
                    </p>

                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            Email atau kata sandi tidak valid. Silakan periksa kembali.
                        </div>
                    @endif

                    <form method="POST" action="{{ route('login') }}">
                        @csrf

                        <div class="mb-3">
                            <label for="email" class="form-label fw-semibold">
                                Alamat Email
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-envelope"></i>
                                </span>

                                <input
                                    id="email"
                                    type="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="Masukkan alamat email"
                                    autocomplete="username"
                                    required
                                    autofocus
                                >
                            </div>

                            @error('email')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                Kata Sandi
                            </label>

                            <div class="input-group">
                                <span class="input-group-text bg-light">
                                    <i class="bi bi-lock"></i>
                                </span>

                                <input
                                    id="password"
                                    type="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Masukkan kata sandi"
                                    autocomplete="current-password"
                                    required
                                >
                            </div>

                            @error('password')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <div class="form-check">
                                <input
                                    id="remember_me"
                                    type="checkbox"
                                    name="remember"
                                    class="form-check-input"
                                >

                                <label for="remember_me" class="form-check-label small">
                                    Ingat saya
                                </label>
                            </div>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}"
                                   class="small text-success text-decoration-none">
                                    Lupa kata sandi?
                                </a>
                            @endif
                        </div>

                        <button type="submit"
                                class="btn btn-success w-100 py-2 fw-semibold">
                            <i class="bi bi-box-arrow-in-right me-2"></i>
                            Masuk ke Sistem
                        </button>
                    </form>
                </div>
            </div>

            <p class="text-center text-secondary small mt-4">
                Dinas Komunikasi, Informatika, Statistik dan Persandian<br>
                Kabupaten Ngawi
            </p>

        </div>
    </div>
</div>
</x-guest-layout>