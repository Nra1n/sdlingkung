<footer class="site-footer">
    <div class="container">
        <div class="row g-4">
            <div class="col-lg-4">
                <div class="footer-brand">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo {{ $site->nama_sekolah }}">
                    <div>
                        <div class="name">{{ $site->nama_sekolah }}</div>
                    </div>
                </div>
                <p class="small mb-0" style="max-width: 330px; line-height: 1.8;">
                    {{ $site->tagline }}. Mewujudkan pendidikan dasar yang berkualitas, ramah anak, dan berwawasan lingkungan.
                </p>
                <div class="footer-social">
                    @if($site->facebook)<a href="{{ $site->facebook }}" target="_blank" rel="noopener" aria-label="Facebook"><i class="bi bi-facebook"></i></a>@endif
                    @if($site->instagram)<a href="{{ $site->instagram }}" target="_blank" rel="noopener" aria-label="Instagram"><i class="bi bi-instagram"></i></a>@endif
                    @if($site->youtube)<a href="{{ $site->youtube }}" target="_blank" rel="noopener" aria-label="YouTube"><i class="bi bi-youtube"></i></a>@endif
                    @if($site->whatsapp)<a href="{{ $site->whatsapp_link }}" target="_blank" rel="noopener" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>@endif
                </div>
            </div>

            <div class="col-6 col-lg-2">
                <h6>Tautan</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('home') }}">Beranda</a></li>
                    <li><a href="{{ route('profil') }}">Profil Sekolah</a></li>
                    <li><a href="{{ route('berita.index') }}">Berita</a></li>
                    <li><a href="{{ route('galeri') }}">Galeri</a></li>
                    <li><a href="{{ route('kontak') }}">Kontak</a></li>
                </ul>
            </div>

            <div class="col-6 col-lg-2">
                <h6>Informasi</h6>
                <ul class="footer-links">
                    <li><a href="{{ route('profil') }}#visi-misi">Visi &amp; Misi</a></li>
                    <li><a href="{{ route('profil') }}#guru">Guru &amp; Staf</a></li>
                    <li><a href="{{ route('profil') }}#prestasi">Prestasi</a></li>
                    <li><a href="{{ route('kontak', ['topik' => 'Pendaftaran Siswa Baru (PPDB)']) }}">Info PPDB</a></li>
                </ul>
            </div>

            <div class="col-lg-4">
                <h6>Hubungi Kami</h6>
                <ul class="footer-contact">
                    <li><i class="bi bi-geo-alt-fill"></i><span>{{ $site->alamat }}</span></li>
                    <li><i class="bi bi-telephone-fill"></i><a href="tel:{{ preg_replace('/\s+/', '', $site->telepon) }}">{{ $site->telepon }}</a></li>
                    <li><i class="bi bi-envelope-fill"></i><a href="mailto:{{ $site->email }}">{{ $site->email }}</a></li>
                    <li><i class="bi bi-clock-fill"></i><span>{{ $site->jam_operasional }}</span></li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-2">
            <span>&copy; {{ date('Y') }} {{ $site->nama_sekolah }}. Hak cipta dilindungi.</span>
            <a href="{{ route('login') }}" class="footer-login" aria-label="Login Admin" title="Login Admin">
                <i class="bi bi-shield-lock"></i>
            </a>
        </div>
    </div>
</footer>
