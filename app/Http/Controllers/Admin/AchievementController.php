<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use Illuminate\Http\Request;

class AchievementController extends Controller
{
    public function index()
    {
        $achievements = Achievement::orderByDesc('year')->orderByDesc('id')->paginate(15);

        return view('admin.prestasi.index', compact('achievements'));
    }

    public function create()
    {
        $achievement = new Achievement(['is_published' => true, 'level' => 'Kecamatan', 'year' => date('Y')]);

        return view('admin.prestasi.create', compact('achievement'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateAchievement($request);
        $validated['is_published'] = $request->boolean('is_published');

        Achievement::create($validated);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil ditambahkan.');
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.prestasi.edit', compact('achievement'));
    }

    public function update(Request $request, Achievement $achievement)
    {
        $validated = $this->validateAchievement($request);
        $validated['is_published'] = $request->boolean('is_published');

        $achievement->update($validated);

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil diperbarui.');
    }

    public function destroy(Achievement $achievement)
    {
        $achievement->delete();

        return redirect()->route('admin.prestasi.index')
            ->with('success', 'Prestasi berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateAchievement(Request $request): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'level' => ['required', 'string', 'in:'.implode(',', Achievement::LEVELS)],
            'year' => ['required', 'integer', 'min:1900', 'max:2100'],
            'description' => ['nullable', 'string', 'max:1000'],
        ], [], [
            'title' => 'judul',
            'level' => 'tingkat',
            'year' => 'tahun',
            'description' => 'deskripsi',
        ]);
    }
}
