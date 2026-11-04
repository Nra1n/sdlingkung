<?php

namespace Database\Seeders;

use App\Models\Achievement;
use Illuminate\Database\Seeder;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            [
                'title' => 'Juara 1 Lomba Cerdas Cermat Tingkat Kecamatan',
                'level' => 'Kecamatan',
                'year' => 2026,
                'description' => 'Tim cerdas cermat SDN Lingkung berhasil meraih juara pertama dan berhak mewakili kecamatan ke tingkat kabupaten.',
            ],
            [
                'title' => 'Juara 2 Lomba Pidato Bahasa Indonesia',
                'level' => 'Kabupaten',
                'year' => 2025,
                'description' => 'Siswa kelas VI meraih juara kedua pada lomba pidato dalam rangka Bulan Bahasa.',
            ],
            [
                'title' => 'Juara 1 Festival Seni Tari Tradisional',
                'level' => 'Kecamatan',
                'year' => 2025,
                'description' => 'Grup tari siswa menampilkan tari tradisional Lombok dan meraih juara pertama.',
            ],
            [
                'title' => 'Juara 3 Olimpiade Matematika SD',
                'level' => 'Kabupaten',
                'year' => 2024,
                'description' => 'Prestasi siswa dalam bidang matematika pada olimpiade tingkat kabupaten.',
            ],
            [
                'title' => 'Sekolah Adiwiyata Tingkat Kabupaten',
                'level' => 'Kabupaten',
                'year' => 2024,
                'description' => 'Penghargaan atas komitmen sekolah dalam menjaga kebersihan dan kelestarian lingkungan.',
            ],
            [
                'title' => 'Juara 2 Lomba Kebersihan Antar Kelas',
                'level' => 'Sekolah',
                'year' => 2026,
                'description' => 'Kelas V meraih juara kedua pada penilaian kebersihan kelas semester ganjil.',
            ],
        ];

        foreach ($items as $item) {
            Achievement::updateOrCreate(
                ['title' => $item['title'], 'year' => $item['year']],
                $item + ['is_published' => true]
            );
        }
    }
}
