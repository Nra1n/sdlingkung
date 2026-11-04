<?php

namespace Database\Seeders;

use App\Models\Teacher;
use Illuminate\Database\Seeder;

class TeacherSeeder extends Seeder
{
    public function run(): void
    {
        $items = [
            ['name' => 'H. Ahmad Fauzan, S.Pd.', 'position' => 'Kepala Sekolah', 'subject' => 'Manajemen Sekolah', 'order' => 1],
            ['name' => 'Siti Rahmawati, S.Pd.', 'position' => 'Guru Kelas', 'subject' => 'Kelas I', 'order' => 2],
            ['name' => 'Lalu Muhammad Iqbal, S.Pd.', 'position' => 'Guru Kelas', 'subject' => 'Kelas II', 'order' => 3],
            ['name' => 'Baiq Nurul Hidayah, S.Pd.', 'position' => 'Guru Kelas', 'subject' => 'Kelas III', 'order' => 4],
            ['name' => 'Muh. Rizki Pratama, S.Pd.', 'position' => 'Guru Kelas', 'subject' => 'Kelas IV', 'order' => 5],
            ['name' => 'Dewi Anggraeni, S.Pd.', 'position' => 'Guru Kelas', 'subject' => 'Kelas V', 'order' => 6],
            ['name' => 'Zainul Muttaqin, S.Pd.', 'position' => 'Guru Kelas', 'subject' => 'Kelas VI', 'order' => 7],
            ['name' => 'Fitriani, S.Pd.', 'position' => 'Guru Mata Pelajaran', 'subject' => 'PJOK', 'order' => 8],
            ['name' => 'Hafizah, S.Pd.I.', 'position' => 'Guru Mata Pelajaran', 'subject' => 'Pendidikan Agama Islam', 'order' => 9],
            ['name' => 'Rudi Hartono', 'position' => 'Tenaga Kependidikan', 'subject' => 'Operator Sekolah', 'order' => 10],
        ];

        foreach ($items as $item) {
            Teacher::updateOrCreate(
                ['name' => $item['name']],
                $item + ['is_active' => true]
            );
        }
    }
}
