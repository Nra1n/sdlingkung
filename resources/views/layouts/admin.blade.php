@php
    $unreadMessages = \App\Models\ContactMessage::unread()->count();
@endphp
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>@yield('title', 'Dashboard') — Admin {{ $site->nama_sekolah }}</title>
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">
    <link href="{{ asset('vendor/fonts/plus-jakarta-sans/plus-jakarta-sans.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v=16" rel="stylesheet">
    @stack('styles')
</head>
<body class="admin-body">

    <aside class="admin-sidebar">
        <a href="{{ route('admin.dashboard') }}" class="sidebar-brand text-decoration-none">
            <img src="{{ asset('images/logo.png') }}" alt="Logo">
            <span>
                <span class="name d-block">{{ $site->nama_sekolah }}</span>
                <span class="sub d-block">Panel Admin</span>
            </span>
        </a>

        <div class="sidebar-label">Utama</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-grid-1x2"></i> Dashboard
                </a>
            </li>
        </ul>

        <div class="sidebar-label">Konten Website</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.berita.index') }}" class="{{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                    <i class="bi bi-newspaper"></i> Berita
                </a>
            </li>
            <li>
                <a href="{{ route('admin.guru.index') }}" class="{{ request()->routeIs('admin.guru.*') ? 'active' : '' }}">
                    <i class="bi bi-people"></i> Guru &amp; Staf
                </a>
            </li>
            <li>
                <a href="{{ route('admin.galeri.index') }}" class="{{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                    <i class="bi bi-images"></i> Galeri
                </a>
            </li>
            <li>
                <a href="{{ route('admin.prestasi.index') }}" class="{{ request()->routeIs('admin.prestasi.*') ? 'active' : '' }}">
                    <i class="bi bi-trophy"></i> Prestasi
                </a>
            </li>
        </ul>

        <div class="sidebar-label">Komunikasi</div>
        <ul class="sidebar-nav">
            <li>
                <a href="{{ route('admin.pesan.index') }}" class="{{ request()->routeIs('admin.pesan.*') ? 'active' : '' }}">
                    <i class="bi bi-envelope"></i> Pesan Masuk
                    @if($unreadMessages > 0)
                        <span class="badge rounded-pill">{{ $unreadMessages }}</span>
                    @endif
                </a>
            </li>
            <li>
                <a href="{{ route('admin.pengaturan.edit') }}" class="{{ request()->routeIs('admin.pengaturan.*') ? 'active' : '' }}">
                    <i class="bi bi-gear"></i> Pengaturan
                </a>
            </li>
        </ul>

        <div class="sidebar-user">
            <div class="who">
                <span class="avatar">{{ \Illuminate\Support\Str::upper(mb_substr(Auth::user()->name ?? 'A', 0, 1)) }}</span>
                <span class="flex-grow-1">
                    <span class="name d-block">{{ Auth::user()->name }}</span>
                    <span class="mail d-block">{{ Auth::user()->email }}</span>
                </span>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="mt-2 px-2">
                @csrf
                <button type="submit" class="btn btn-sm w-100 text-start" style="color: #d9b3b3; background: rgba(255,255,255,.06);">
                    <i class="bi bi-box-arrow-left me-2"></i>Keluar
                </button>
            </form>
        </div>
    </aside>

    <div class="sidebar-backdrop"></div>

    <div class="admin-main">
        <header class="admin-topbar">
            <div class="d-flex align-items-center gap-3">
                <button type="button" class="btn btn-sm btn-outline-secondary d-lg-none" data-sidebar-toggle aria-label="Buka menu">
                    <i class="bi bi-list"></i>
                </button>
                <div>
                    <h1>@yield('heading', 'Dashboard')</h1>
                    <div class="crumb">@yield('subheading', 'Ringkasan pengelolaan website sekolah')</div>
                </div>
            </div>
            <div class="d-flex align-items-center gap-2">
                <a href="{{ route('home') }}" target="_blank" rel="noopener" class="btn btn-sm btn-outline-secondary d-none d-md-inline-flex">
                    <i class="bi bi-globe me-1"></i>Website
                </a>
            </div>
        </header>

        <div class="admin-content">
            @include('partials.flash')
            @yield('konten')
        </div>
    </div>

    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}?v=2"></script>
    @stack('scripts')
</body>
</html>
