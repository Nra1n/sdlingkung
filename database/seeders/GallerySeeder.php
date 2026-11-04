<?php

namespace Database\Seeders;

use App\Models\Gallery;
use Illuminate\Database\Seeder;

class GallerySeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['title' => 'Gedung Sekolah', 'category' => 'Fasilitas', 'image' => 'images/seed/sekolah.jpg', 'description' => 'Tampak depan gedung SDN Lingkung.'],
            ['title' => 'Kegiatan Belajar di Kelas', 'category' => 'Pembelajaran', 'image' => 'images/seed/kelas.jpg', 'description' => 'Suasana pembelajaran interaktif di ruang kelas.'],
            ['title' => 'Perpustakaan Sekolah', 'category' => 'Fasilitas', 'image' => 'images/seed/perpustakaan.jpg', 'description' => 'Koleksi buku bacaan untuk mendukung gerakan literasi.'],
            ['title' => 'Senam Pagi Bersama', 'category' => 'Kegiatan', 'image' => 'images/seed/kegiatan.jpg', 'description' => 'Kegiatan senam pagi untuk menjaga kebugaran siswa.'],
            ['title' => 'Belajar Kelompok', 'category' => 'Pembelajaran', 'image' => 'images/seed/belajar.jpg', 'description' => 'Siswa berdiskusi dalam kelompok belajar.'],
            ['title' => 'Rapat Guru dan Orang Tua', 'category' => 'Kegiatan', 'image' => 'images/seed/tim.jpg', 'description' => 'Koordinasi antara sekolah dan orang tua siswa.'],
            ['title' => 'Kegiatan Pramuka', 'category' => 'Kegiatan', 'image' => 'images/seed/siswa.jpg', 'description' => 'Pembinaan karakter melalui kegiatan ekstrakurikuler.'],
            ['title' => 'Suasana Pembelajaran', 'category' => 'Pembelajaran', 'image' => 'images/seed/hero.jpg', 'description' => 'Guru mendampingi siswa dalam kegiatan belajar.'],
        ];

        foreach ($items as $item) {
            Gallery::updateOrCreate(
                ['title' => $item['title']],
                $item + ['is_published' => true]
            );
        }
    }
}
