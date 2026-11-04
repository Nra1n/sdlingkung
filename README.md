# SDN Lingkung — Website Sekolah

Website profil dan informasi **SD Negeri Lingkung** berbasis **Laravel 12**. Terdiri dari halaman publik untuk pengunjung dan panel admin untuk mengelola seluruh konten tanpa mengubah kode.

---

## Daftar Isi

- [Fitur](#fitur)
- [Teknologi](#teknologi)
- [Persyaratan](#persyaratan)
- [Instalasi](#instalasi)
- [Akun Admin](#akun-admin)
- [Struktur & Alur Kerja](#struktur--alur-kerja)
- [Lokasi Unggahan Gambar](#lokasi-unggahan-gambar)
- [Pengujian](#pengujian)
- [Catatan Penting](#catatan-penting)
- [Deploy ke Hosting](#deploy-ke-hosting)

---

## Fitur

### Halaman Publik

| Halaman | URL | Keterangan |
| --- | --- | --- |
| Beranda | `/` | Hero, statistik sekolah, berita terbaru, sambutan kepala sekolah, prestasi, galeri |
| Profil | `/profil` | Sejarah, visi & misi, data sekolah, daftar guru |
| Berita | `/berita` | Daftar berita tayang + pencarian & filter kategori |
| Detail Berita | `/berita/{slug}` | Isi berita, penulis, jumlah dilihat, berita terkait |
| Galeri | `/galeri` | Grid foto dengan lightbox |
| Kontak | `/kontak` | Alamat, peta, jam operasional, formulir pesan |
| Login | `/login` | Masuk ke panel admin |
| Sitemap | `/sitemap.xml` | Sitemap otomatis untuk mesin pencari |
| Robots | `/robots.txt` | Melarang crawler mengindeks area `/admin` |

### Panel Admin (`/admin`)

- **Dashboard** — ringkasan jumlah berita, guru, galeri, prestasi, pesan belum dibaca, dan grafik kunjungan berita.
- **Berita** — tambah, ubah, hapus, unggah gambar, atur status tayang/draf.
- **Guru** — kelola data guru & staf (nama, NIP, jabatan, mata pelajaran, foto, urutan).
- **Galeri** — kelola foto kegiatan/fasilitas beserta kategori.
- **Prestasi** — catat prestasi siswa/sekolah (tingkat, tahun, deskripsi).
- **Pesan** — kotak masuk formulir kontak; pesan otomatis ditandai terbaca saat dibuka.
- **Pengaturan** — nama sekolah, tagline, alamat, kontak, sosial media, visi/misi, sambutan, statistik, dan embed peta. Perubahan langsung tampil di seluruh halaman.

### Keamanan

- Middleware `admin` memastikan hanya user dengan `is_admin = true` yang bisa masuk panel.
- Login dilindungi **rate limiting** (5 percobaan per menit).
- Semua form memakai proteksi **CSRF** bawaan Laravel.
- Formulir kontak memiliki **honeypot** anti-spam.
- Pesan validasi tampil dalam **Bahasa Indonesia** (`lang/id`).

---

## Teknologi

- **Laravel 12** (PHP >= 8.2)
- **MySQL** (produksi & pengembangan)
- **SQLite in-memory** (pengujian otomatis)
- **Bootstrap 5** via CDN + CSS kustom (`public/css/app.css`)
- **JavaScript vanilla** (`public/js/app.js`) — tanpa build tool/npm
- Font & ikon via CDN (Google Fonts, Bootstrap Icons)

Tidak ada langkah `npm install` / `npm run build`. Aset langsung disajikan dari folder `public/`.

---

## Persyaratan

- PHP **8.2+** dengan ekstensi `pdo_mysql`, `fileinfo`, `mbstring`, `openssl`
- Composer 2
- MySQL 5.7+ / MariaDB 10.3+
- Web server (Apache/Nginx) atau `php artisan serve` untuk pengembangan

---

## Instalasi

```bash
# 1. Dependensi PHP
composer install

# 2. Salin konfigurasi environment
copy .env.example .env      # Windows
# cp .env.example .env      # Linux/macOS

# 3. Generate application key
php artisan key:generate

# 4. Buat database MySQL
#    CREATE DATABASE sdnlingkung CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

# 5. Sesuaikan kredensial database di .env (DB_DATABASE, DB_USERNAME, DB_PASSWORD)

# 6. Jalankan migrasi + data contoh
php artisan migrate --seed

# 7. Jalankan server pengembangan
php artisan serve
```

Buka **http://127.0.0.1:8000**.

### Perintah yang sering dipakai

```bash
php artisan migrate:fresh --seed   # reset database & isi ulang data contoh
php artisan storage:link           # TIDAK diperlukan (lihat bagian unggahan)
php artisan config:clear           # setelah mengubah .env
php artisan route:list            # daftar seluruh route
php artisan test                   # jalankan pengujian otomatis
```

---

## Akun Admin

Setelah `migrate --seed`:

| Field | Nilai |
| --- | --- |
| Email | `admin@sdnlingkung.sch.id` |
| Password | `admin123` |

> **Wajib diganti sebelum website dipublikasikan.** Ubah password langsung di database atau melalui `php artisan tinker`:
>
> ```bash
> php artisan tinker
> >>> App\Models\User::where('email','admin@sdnlingkung.sch.id')->update(['password' => bcrypt('password-baru-anda')]);
> ```
>
> Kredensial demo hanya ditampilkan di halaman login saat `APP_ENV=local`.

Untuk menambah admin baru, buat user dengan kolom `is_admin = true`.

---

## Struktur & Alur Kerja

Alur standar Laravel: **Route → Controller → Model → View**.

```
app/
├── Http/
│   ├── Controllers/
│   │   ├── HomeController.php          # beranda
│   │   ├── PageController.php          # profil, kontak
│   │   ├── NewsController.php          # berita publik
│   │   ├── GalleryController.php       # galeri publik
│   │   ├── ContactController.php       # simpan pesan kontak
│   │   ├── SitemapController.php       # sitemap
│   │   ├── Auth/LoginController.php    # login & logout
│   │   └── Admin/                      # CRUD panel admin
│   ├── Middleware/EnsureUserIsAdmin.php
│   └── Requests/                       # validasi form (jika ada)
├── Models/
│   ├── News.php
│   ├── Teacher.php
│   ├── Gallery.php
│   ├── Achievement.php
│   ├── ContactMessage.php
│   ├── SiteSetting.php                 # pengaturan global (1 baris)
│   └── User.php
└── Support/Media.php                   # helper simpan/hapus unggahan

resources/views/
├── layouts/main.blade.php              # layout publik
├── layouts/admin.blade.php             # layout panel admin
├── partials/                           # navbar, footer, kartu, modal, flash
├── admin/                              # index + form tiap modul
└── ...                                 # halaman publik

routes/web.php                          # semua route publik, auth, admin
public/
├── css/app.css                         # design system + style admin
├── js/app.js                           # lightbox, reveal, konfirmasi hapus
├── images/seed/                        # gambar contoh
└── uploads/                            # hasil unggahan admin
```

### Contoh alur satu fitur — Berita

1. **Route** `GET /berita/{slug}` → `NewsController@show` (`routes/web.php`)
2. **Controller** mengambil berita tayang berdasarkan `slug`, menambah kolom `views`, lalu memuat berita terkait.
3. **Model** `News` memakai `getRouteKeyName() = 'slug'`, sehingga URL memakai slug (bukan ID).
4. **View** `resources/views/berita/show.blade.php` me-render isi berita di dalam `layouts/main.blade.php`.
5. **Halaman admin** `GET /admin/berita` → `Admin\NewsController@index` (butuh login + `admin` middleware).

Pengaturan sekolah diakses dari mana saja lewat `SiteSetting::current()` dan dibagikan otomatis ke semua view oleh `View::composer('*')` di `app/Providers/AppServiceProvider.php`. Hasilnya tersedia sebagai variabel `$site` di setiap Blade.

---

## Lokasi Unggahan Gambar

Semua unggahan disimpan **langsung** di `public/uploads/{folder}` melalui `App\Support\Media`. Pendekatan ini sengaja dipilih agar tidak memerlukan `php artisan storage:link` — cocok untuk shared hosting dan Windows.

| Folder | Dipakai untuk |
| --- | --- |
| `public/uploads/berita/` | gambar berita |
| `public/uploads/guru/` | foto guru |
| `public/uploads/galeri/` | foto galeri |
| `public/uploads/prestasi/` | foto prestasi |
| `public/uploads/pengaturan/` | logo & foto kepala sekolah |

Nama file diberi awalan waktu + string acak agar tidak bentrok. Saat gambar diganti atau data dihapus, file lama otomatis dihapus. Folder `public/uploads` harus **dapat ditulis** oleh web server.

Gambar bawaan (data contoh) berada di `public/images/seed/`.

---

## Pengujian

```bash
php artisan test
```

Menggunakan SQLite in-memory (lihat `phpunit.xml`), jadi tidak menyentuh database MySQL Anda.

Cakupan saat ini (**43 test, 158 assertion**):

| File | Isi |
| --- | --- |
| `tests/Feature/PublicPagesTest.php` | beranda, profil, berita, galeri, kontak, sitemap, robots, 404 |
| `tests/Feature/AuthTest.php` | login, logout, penolakan non-admin, proteksi route |
| `tests/Feature/AdminNewsTest.php` | CRUD berita + unggah/hapus gambar |
| `tests/Feature/AdminManagementTest.php` | CRUD guru, galeri, prestasi, pesan, pengaturan |
| `tests/Feature/ContactFormTest.php` | validasi, honeypot, pesan masuk inbox |

Catatan: server tanpa ekstensi **GD** tetap bisa menjalankan test karena unggahan gambar diuji dengan menyalin file JPG asli, bukan `UploadedFile::fake()->image()`.

---

## Catatan Penting

- **Semua data hasil seeder adalah contoh/dummy**: nama guru, sejarah, prestasi, alamat, nomor telepon, NPSN (`5020xxxx`), dan gambar Unsplash. Ganti dengan data resmi sekolah melalui panel admin sebelum dipublikasikan.
- Zona waktu diatur `Asia/Makassar` (`APP_TIMEZONE`). Sesuaikan bila berbeda.
- Bahasa aplikasi `id` dengan fallback `en` (`APP_LOCALE`, `APP_FALLBACK_LOCALE`).
- Panel admin berada di `/admin` dan sudah diblokir dari crawler melalui `robots.txt`.
- Jangan commit file `.env`. Gunakan `.env.example` sebagai acuan konfigurasi.
- Backup folder `public/uploads` bersama database secara berkala.

---

## Deploy ke Hosting

1. Upload seluruh proyek ke hosting, arahkan **document root** ke folder `public/`.
   Jika hosting tidak mengizinkan, gunakan `.htaccess` di root atau pindahkan isi `public/` dan sesuaikan `index.php`.
2. Set `.env` produksi:
   ```env
   APP_ENV=production
   APP_DEBUG=false
   APP_URL=https://domain-sekolah.sch.id
   ```
3. Jalankan:
   ```bash
   composer install --no-dev --optimize-autoloader
   php artisan migrate --force
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```
4. Pastikan `storage/` dan `bootstrap/cache/` dapat ditulis, serta `public/uploads/` memiliki izin tulis.
5. Ganti password admin demo.

---

## Lisensi

Dibuat untuk keperluan website **SD Negeri Lingkung**. Framework Laravel berlisensi [MIT](https://opensource.org/licenses/MIT).
