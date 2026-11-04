<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\SiteSetting;
use App\Models\Teacher;

class PageController extends Controller
{
    public function profil()
    {
        $site = SiteSetting::current();

        $teachers = Teacher::active()->ordered()->get();

        $achievements = Achievement::published()
            ->orderByDesc('year')
            ->orderByDesc('id')
            ->get();

        return view('profil', compact('site', 'teachers', 'achievements'));
    }

    public function kontak()
    {
        $site = SiteSetting::current();

        // Dipakai untuk mengisi otomatis kolom subjek, misalnya dari tombol "Info PPDB".
        $topik = (string) request('topik', '');

        return view('kontak', compact('site', 'topik'));
    }
}
