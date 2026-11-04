<nav class="navbar navbar-expand-lg site-header py-2">
    <div class="container">
        <a class="navbar-brand" href="{{ route('home') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Logo {{ $site->nama_sekolah }}">
            <span class="brand-text">
                <span class="brand-name">{{ $site->nama_sekolah }}</span>
            </span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Buka menu">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-lg-center">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('profil') ? 'active' : '' }}" href="{{ route('profil') }}">Profil</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('berita.*') ? 'active' : '' }}" href="{{ route('berita.index') }}">Berita</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('galeri') ? 'active' : '' }}" href="{{ route('galeri') }}">Galeri</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('kontak*') ? 'active' : '' }}" href="{{ route('kontak') }}">Kontak</a>
                </li>
                <li class="nav-item ms-lg-3 nav-cta">
                    <a class="btn btn-primary btn-sm px-3" href="{{ route('kontak', ['topik' => 'Pendaftaran Siswa Baru (PPDB)']) }}">
                        <i class="bi bi-megaphone me-1"></i> Info PPDB
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
