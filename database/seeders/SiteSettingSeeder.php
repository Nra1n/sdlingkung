<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use Illuminate\Database\Seeder;

class SiteSettingSeeder extends Seeder
{
    public function run(): void
    {
        SiteSetting::updateOrCreate(
            ['id' => 1],
            [
                'nama_sekolah' => 'SDN Lingkung',
                'tagline' => 'Membentuk Generasi Cerdas',
                'alamat' => 'Jl. Pendidikan No. 1, Desa Lingkung, Kabupaten Lombok Barat, Nusa Tenggara Barat',
                'telepon' => '(0370) 123456',
                'email' => 'info@sdnlingkung.sch.id',
                'whatsapp' => '6281234567890',
                'jam_operasional' => 'Senin – Sabtu, 07.00 – 14.00 WITA',
                'akreditasi' => 'A',
                'kepala_sekolah' => 'H. Ahmad Fauzan, S.Pd.',
                'sambutan' => 'Assalamu\'alaikum warahmatullahi wabarakatuh. Selamat datang di website resmi SDN Lingkung. '
                    ."Website ini kami hadirkan sebagai jembatan informasi antara sekolah, orang tua, dan masyarakat.\n\n"
                    .'Kami percaya bahwa pendidikan yang berkualitas lahir dari kerja sama yang baik antara guru, siswa, orang tua, dan lingkungan. '
                    .'Oleh karena itu, mari bersama-sama mendukung setiap anak tumbuh menjadi pribadi yang cerdas, berkarakter, dan berakhlak mulia.',
                'visi' => 'Terwujudnya peserta didik yang beriman, cerdas, terampil, mandiri, dan berbudi pekerti luhur serta peduli terhadap lingkungan.',
                'misi' => "Menyelenggarakan pembelajaran aktif, inovatif, kreatif, efektif, dan menyenangkan.\n"
                    ."Menanamkan nilai keimanan, ketakwaan, dan akhlak mulia dalam seluruh kegiatan sekolah.\n"
                    ."Mengembangkan potensi siswa sesuai minat, bakat, dan kemampuan melalui kegiatan ekstrakurikuler.\n"
                    ."Meningkatkan profesionalisme dan kompetensi tenaga pendidik serta kependidikan.\n"
                    ."Mewujudkan lingkungan sekolah yang bersih, aman, nyaman, dan ramah anak.",
                'sejarah' => 'SDN Lingkung berdiri sejak tahun 1985 sebagai wujud kepedulian masyarakat Desa Lingkung terhadap pendidikan dasar. '
                    .'Dengan dukungan tanah wakaf dari warga dan bantuan pemerintah, sekolah ini terus berkembang dari bangunan sederhana menjadi '
                    ."lembaga pendidikan dasar yang dipercaya masyarakat.\n\n"
                    .'Kini SDN Lingkung memiliki ruang kelas yang memadai, perpustakaan, sarana olahraga, dan tenaga pengajar profesional. '
                    .'Berbagai prestasi akademik maupun nonakademik telah diraih siswa di tingkat kecamatan hingga kabupaten.',
                'jumlah_siswa' => 186,
                'jumlah_guru' => 12,
                'jumlah_kelas' => 6,
                'tahun_berdiri' => 1985,
                'facebook' => 'https://facebook.com/',
                'instagram' => 'https://instagram.com/',
                'youtube' => 'https://youtube.com/',
                'maps_embed' => 'https://www.google.com/maps?q=SDN+Lingkung+Lombok+Barat&output=embed',
            ]
        );
    }
}
