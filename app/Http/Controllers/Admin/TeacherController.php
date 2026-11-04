<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Teacher;
use App\Support\Media;
use Illuminate\Http\Request;

class TeacherController extends Controller
{
    public function index()
    {
        $teachers = Teacher::ordered()->paginate(15);

        return view('admin.guru.index', compact('teachers'));
    }

    public function create()
    {
        $teacher = new Teacher(['is_active' => true, 'order' => (Teacher::max('order') + 1)]);

        return view('admin.guru.create', compact('teacher'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateTeacher($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            $validated['photo'] = Media::store($request->file('photo'), 'guru');
        }

        Teacher::create($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru/staf berhasil ditambahkan.');
    }

    public function edit(Teacher $teacher)
    {
        return view('admin.guru.edit', compact('teacher'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $this->validateTeacher($request);
        $validated['is_active'] = $request->boolean('is_active');

        if ($request->hasFile('photo')) {
            Media::delete($teacher->photo);
            $validated['photo'] = Media::store($request->file('photo'), 'guru');
        }

        $teacher->update($validated);

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru/staf berhasil diperbarui.');
    }

    public function destroy(Teacher $teacher)
    {
        Media::delete($teacher->photo);
        $teacher->delete();

        return redirect()->route('admin.guru.index')
            ->with('success', 'Data guru/staf berhasil dihapus.');
    }

    /**
     * @return array<string, mixed>
     */
    private function validateTeacher(Request $request): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'nip' => ['nullable', 'string', 'max:40'],
            'position' => ['required', 'string', 'max:80'],
            'subject' => ['nullable', 'string', 'max:80'],
            'order' => ['nullable', 'integer', 'min:0', 'max:999'],
            'photo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ], [], [
            'name' => 'nama',
            'nip' => 'NIP',
            'position' => 'jabatan',
            'subject' => 'mata pelajaran',
            'order' => 'urutan',
            'photo' => 'foto',
        ]);
    }
}
