<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Beranda') — {{ $site->nama_sekolah }}</title>

    <meta name="description" content="@yield('meta_description', $site->tagline)">
    <meta name="theme-color" content="#ffffff">
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}">

    <meta property="og:type" content="website">
    <meta property="og:site_name" content="{{ $site->nama_sekolah }}">
    <meta property="og:title" content="@yield('title', 'Beranda') — {{ $site->nama_sekolah }}">
    <meta property="og:description" content="@yield('meta_description', $site->tagline)">
    <meta property="og:image" content="@yield('og_image', asset('images/seed/sekolah.jpg'))">

    <link href="{{ asset('vendor/fonts/plus-jakarta-sans/plus-jakarta-sans.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('vendor/bootstrap-icons/bootstrap-icons.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/app.css') }}?v=19" rel="stylesheet">
    @stack('styles')
</head>
<body class="public-body {{ request()->routeIs('home') ? 'home-page' : '' }}">

    @include('partials.navbar', ['site' => $site])

    <main>
        @include('partials.flash')
        @yield('konten')
    </main>

    @include('partials.footer', ['site' => $site])

    {{-- Tombol WhatsApp mengambang --}}
    @if($site->whatsapp)
        <a href="{{ $site->whatsapp_link }}" target="_blank" rel="noopener" class="wa-float" aria-label="Chat WhatsApp">
            <i class="bi bi-whatsapp"></i>
        </a>
    @endif

    <script src="{{ asset('vendor/bootstrap/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}?v=2"></script>
    @stack('scripts')
</body>
</html>
