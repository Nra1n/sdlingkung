<?php

namespace Database\Seeders;

use App\Models\News;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $adminId = User::where('is_admin', true)->value('id');

        $items = [
            [
                'title' => 'Penerimaan Peserta Didik Baru Tahun Ajaran 2026/2027 Resmi Dibuka',
                'category' => 'PPDB',
                'image' => 'images/seed/sekolah.jpg',
                'excerpt' => 'Pendaftaran peserta didik baru SDN Lingkung dibuka mulai 1 Mei hingga 30 Juni 2026. Calon siswa baru dapat mendaftar secara langsung di sekolah.',
                'content' => "SDN Lingkung resmi membuka pendaftaran peserta didik baru (PPDB) untuk tahun ajaran 2026/2027. Pendaftaran dibuka mulai 1 Mei sampai 30 Juni 2026 pada hari Senin–Sabtu, pukul 07.00–13.00 WITA.\n\nCalon peserta didik diharapkan telah berusia minimal enam tahun pada 1 Juli 2026. Berkas yang perlu disiapkan meliputi fotokopi akta kelahiran, fotokopi kartu keluarga, pas foto ukuran 3x4 sebanyak dua lembar, serta fotokopi KIA bagi yang sudah memiliki.\n\nPendaftaran dapat dilakukan langsung di kantor sekolah. Panitia PPDB akan membantu orang tua dalam proses pengisian formulir dan verifikasi berkas. Kuota rombongan belajar tahun ini terbatas, sehingga orang tua diimbau mendaftar lebih awal.\n\nInformasi lebih lanjut dapat diperoleh melalui nomor WhatsApp sekolah atau datang langsung ke kantor SDN Lingkung pada jam kerja.",
                'days_ago' => 2,
            ],
            [
                'title' => 'Siswa SDN Lingkung Raih Juara 1 Lomba Cerdas Cermat Tingkat Kecamatan',
                'category' => 'Prestasi',
                'image' => 'images/seed/siswa.jpg',
                'excerpt' => 'Tim cerdas cermat SDN Lingkung berhasil menyisihkan belasan sekolah lain dan meraih juara pertama tingkat kecamatan.',
                'content' => "Kabar membanggakan datang dari tim cerdas cermat SDN Lingkung. Tiga siswa terbaik sekolah berhasil meraih juara 1 pada Lomba Cerdas Cermat (LCC) tingkat kecamatan yang diikuti oleh belasan sekolah dasar.\n\nKompetisi berlangsung dalam tiga babak, meliputi soal wajib, soal lemparan, dan babak cepat tangkas. Tim SDN Lingkung tampil tenang dan konsisten sehingga berhasil mengumpulkan poin tertinggi.\n\nKepala sekolah menyampaikan apresiasi kepada siswa dan guru pembimbing. \"Prestasi ini adalah hasil kerja keras anak-anak dan pendampingan guru. Semoga menjadi motivasi untuk terus belajar,\" ujarnya.\n\nSelanjutnya, tim akan mewakili kecamatan pada tingkat kabupaten. Sekolah mengajak seluruh warga sekolah memberikan dukungan dan doa agar meraih hasil terbaik.",
                'days_ago' => 6,
            ],
            [
                'title' => 'Gerakan Literasi Sekolah: 15 Menit Membaca Sebelum Pelajaran',
                'category' => 'Kegiatan',
                'image' => 'images/seed/perpustakaan.jpg',
                'excerpt' => 'Setiap pagi sebelum kegiatan belajar dimulai, seluruh siswa membaca buku pilihan selama 15 menit untuk menumbuhkan budaya literasi.',
                'content' => "SDN Lingkung menerapkan program Gerakan Literasi Sekolah (GLS) yang dilaksanakan setiap pagi sebelum jam pelajaran pertama. Selama 15 menit, seluruh siswa membaca buku pilihan mereka secara mandiri.\n\nProgram ini bertujuan menumbuhkan kebiasaan membaca, memperkaya kosakata, serta meningkatkan kemampuan memahami bacaan. Buku yang tersedia meliputi cerita rakyat, buku pengetahuan, majalah anak, dan buku bergambar.\n\nSetelah membaca, siswa diajak menceritakan kembali isi bacaan secara singkat. Kegiatan ini sekaligus melatih keberanian dan kemampuan berbicara di depan kelas.\n\nPerpustakaan sekolah terus menambah koleksi buku bacaan baru. Orang tua juga diundang untuk mendukung program dengan mendampingi anak membaca di rumah.",
                'days_ago' => 12,
            ],
            [
                'title' => 'Peringatan Hari Pendidikan Nasional 2026 Berlangsung Khidmat',
                'category' => 'Kegiatan',
                'image' => 'images/seed/kegiatan.jpg',
                'excerpt' => 'Upacara bendera dan pentas seni mewarnai peringatan Hari Pendidikan Nasional di SDN Lingkung.',
                'content' => "SDN Lingkung memperingati Hari Pendidikan Nasional 2026 melalui upacara bendera yang berlangsung khidmat di halaman sekolah. Seluruh siswa, guru, dan tenaga kependidikan mengenakan pakaian adat daerah.\n\nDalam amanatnya, pembina upacara menyampaikan pentingnya pendidikan sebagai fondasi pembangunan bangsa. Beliau mengajak seluruh warga sekolah untuk terus belajar dan beradaptasi dengan perkembangan zaman.\n\nSetelah upacara, kegiatan dilanjutkan dengan pentas seni antar kelas. Siswa menampilkan tari tradisional, puisi, dan nyanyian daerah. Acara berlangsung meriah dan penuh semangat.\n\nKegiatan ini diharapkan dapat menumbuhkan rasa cinta terhadap budaya serta meningkatkan semangat belajar siswa.",
                'days_ago' => 20,
            ],
            [
                'title' => 'Jadwal Penilaian Akhir Semester Ganjil 2026/2027 Telah Diumumkan',
                'category' => 'Pengumuman',
                'image' => 'images/seed/kelas.jpg',
                'excerpt' => 'Penilaian Akhir Semester Ganjil akan dilaksanakan pada 1–8 Desember 2026. Siswa diimbau mempersiapkan diri dengan baik.',
                'content' => "Sehubungan dengan berakhirnya kegiatan pembelajaran semester ganjil, SDN Lingkung akan melaksanakan Penilaian Akhir Semester (PAS) pada 1–8 Desember 2026.\n\nPenilaian dilaksanakan untuk seluruh kelas I sampai kelas VI. Jadwal lengkap per mata pelajaran dapat dilihat pada papan pengumuman sekolah dan dibagikan melalui wali kelas masing-masing.\n\nSiswa diimbau mempersiapkan diri dengan belajar rutin, menjaga kesehatan, dan membawa perlengkapan ujian dengan lengkap. Orang tua diharapkan turut mendampingi belajar anak di rumah.\n\nSiswa yang berhalangan hadir karena sakit wajib menyertakan surat keterangan dokter dan mengikuti ujian susulan sesuai jadwal yang ditetapkan sekolah.",
                'days_ago' => 28,
            ],
            [
                'title' => 'Workshop Literasi Digital untuk Guru dan Orang Tua Siswa',
                'category' => 'Umum',
                'image' => 'images/seed/tim.jpg',
                'excerpt' => 'Sekolah menggelar workshop literasi digital untuk membekali guru dan orang tua dalam mendampingi anak di dunia digital.',
                'content' => "SDN Lingkung menggelar workshop literasi digital yang diikuti oleh guru dan perwakilan orang tua siswa. Kegiatan ini menghadirkan narasumber dari komunitas literasi digital setempat.\n\nMateri yang dibahas meliputi cara menggunakan internet secara aman, mengenali berita palsu, mengelola waktu layar anak, serta pentingnya pendampingan orang tua dalam menggunakan media sosial.\n\nPeserta antusias mengikuti diskusi dan praktik langsung menggunakan perangkat masing-masing. Beberapa orang tua menyampaikan pengalaman dan tantangan dalam mendampingi anak belajar daring.\n\nSekolah berencana menjadikan workshop ini sebagai kegiatan rutin tahunan agar seluruh warga sekolah memiliki pemahaman digital yang memadai.",
                'days_ago' => 40,
            ],
        ];

        foreach ($items as $item) {
            $slug = Str::slug($item['title']);

            News::updateOrCreate(
                ['slug' => $slug],
                [
                    'user_id' => $adminId,
                    'title' => $item['title'],
                    'category' => $item['category'],
                    'excerpt' => $item['excerpt'],
                    'content' => $item['content'],
                    'image' => $item['image'],
                    'is_published' => true,
                    'published_at' => now()->subDays($item['days_ago']),
                ]
            );
        }
    }
}
