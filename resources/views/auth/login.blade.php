<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Admin — SD Negeri Lingkung</title>
    <meta name="robots" content="noindex, nofollow">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link href="{{ asset('vendor/fonts/plus-jakarta-sans/plus-jakarta-sans.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v=15" rel="stylesheet">
</head>
<body>
    <div class="auth-body">
        <aside class="auth-side">
            <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" width="44" height="44">
                <span>
                    <span class="d-block fw-bold text-white">SD Negeri Lingkung</span>
                    <span class="d-block" style="font-size: .66rem; letter-spacing: .14em; text-transform: uppercase; color: #4ce1f6;">Panel Admin</span>
                </span>
            </a>

            <div class="auth-quote">
                <h2>Kelola informasi sekolah dengan mudah.</h2>
                <p class="mt-3 mb-0">
                    Perbarui berita, data guru, galeri, prestasi, dan pengaturan website
                    dari satu tempat.
                </p>
            </div>

            <div class="small" style="color: #8fd3e4;">
                &copy; {{ date('Y') }} SD Negeri Lingkung. Hak cipta dilindungi.
            </div>
        </aside>

        <main class="auth-form-wrap">
            <div class="auth-card">
                <a href="{{ route('home') }}" class="d-inline-flex align-items-center gap-2 text-decoration-none mb-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo">
                    <span class="fw-bold" style="color: var(--ink);">SD Negeri Lingkung</span>
                </a>

                <h1 class="mb-1" style="font-size: 1.65rem;">Selamat Datang</h1>
                <p class="text-muted mb-4">Masuk untuk mengelola konten website sekolah.</p>

                @if($errors->any())
                    <div class="alert alert-danger border-0 small">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>{{ $errors->first() }}
                    </div>
                @endif

                @if(session('success'))
                    <div class="alert alert-success border-0 small">
                        <i class="bi bi-check-circle-fill me-2"></i>{{ session('success') }}
                    </div>
                @endif

                <form action="{{ route('login.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-envelope"></i></span>
                            <input type="email" class="form-control @error('email') is-invalid @enderror"
                                   id="email" name="email" value="{{ old('email') }}"
                                   placeholder="admin@sdnlingkung.sch.id" required autofocus autocomplete="username">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Password</label>
                        <div class="input-group">
                            <span class="input-group-text bg-white"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" id="password" name="password"
                                   placeholder="Masukkan password" required autocomplete="current-password">
                            <button class="btn btn-outline-secondary" type="button" id="togglePassword" aria-label="Tampilkan password">
                                <i class="bi bi-eye"></i>
                            </button>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="remember" id="remember" value="1">
                            <label class="form-check-label small" for="remember">Ingat saya</label>
                        </div>
                        <a href="{{ route('home') }}" class="small">Kembali ke website</a>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-box-arrow-in-right me-2"></i>Masuk ke Panel Admin
                    </button>
                </form>
            </div>
        </main>
    </div>

    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script>
        document.getElementById('togglePassword')?.addEventListener('click', function () {
            const input = document.getElementById('password');
            const icon = this.querySelector('i');
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            icon.className = show ? 'bi bi-eye-slash' : 'bi bi-eye';
        });
    </script>
</body>
</html>
