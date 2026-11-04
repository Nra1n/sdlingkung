<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Support\Media;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function edit()
    {
        $site = SiteSetting::current();

        return view('admin.pengaturan.edit', compact('site'));
    }

    public function update(Request $request)
    {
        $site = SiteSetting::current();

        $validated = $request->validate([
            'nama_sekolah' => ['required', 'string', 'max:120'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'alamat' => ['nullable', 'string', 'max:500'],
            'telepon' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:150'],
            'whatsapp' => ['nullable', 'string', 'max:30'],
            'jam_operasional' => ['nullable', 'string', 'max:120'],
            'akreditasi' => ['nullable', 'string', 'max:10'],
            'kepala_sekolah' => ['nullable', 'string', 'max:120'],
            'foto_kepala_sekolah' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'sambutan' => ['nullable', 'string', 'max:5000'],
            'visi' => ['nullable', 'string', 'max:2000'],
            'misi' => ['nullable', 'string', 'max:5000'],
            'sejarah' => ['nullable', 'string', 'max:10000'],
            'jumlah_siswa' => ['nullable', 'integer', 'min:0', 'max:5000'],
            'jumlah_guru' => ['nullable', 'integer', 'min:0', 'max:500'],
            'jumlah_kelas' => ['nullable', 'integer', 'min:0', 'max:100'],
            'tahun_berdiri' => ['nullable', 'integer', 'min:1900', 'max:2100'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'maps_embed' => ['nullable', 'string', 'max:2000'],
            'hero_image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'hapus_hero_image' => ['nullable', 'boolean'],
        ], [], [
            'nama_sekolah' => 'nama sekolah',
            'foto_kepala_sekolah' => 'foto kepala sekolah',
            'jumlah_siswa' => 'jumlah siswa',
            'jumlah_guru' => 'jumlah guru',
            'jumlah_kelas' => 'jumlah kelas',
        ]);

        // Bila pengguna menempel kode <iframe>, ambil URL src-nya saja.
        if (! empty($validated['maps_embed']) && str_contains($validated['maps_embed'], '<iframe')) {
            preg_match('/src=["\']([^"\']+)["\']/', $validated['maps_embed'], $matches);
            $validated['maps_embed'] = $matches[1] ?? null;
        }

        if ($request->hasFile('foto_kepala_sekolah')) {
            Media::delete($site->foto_kepala_sekolah);
            $validated['foto_kepala_sekolah'] = Media::store($request->file('foto_kepala_sekolah'), 'sekolah');
        }

        unset($validated['hapus_hero_image']);

        if ($request->hasFile('hero_image')) {
            Media::delete($site->hero_image);
            $validated['hero_image'] = Media::store($request->file('hero_image'), 'sekolah');
        } elseif ($request->boolean('hapus_hero_image')) {
            Media::delete($site->hero_image);
            $validated['hero_image'] = null;
        }

        $site->fill($validated)->save();
        SiteSetting::forgetCurrent();

        return redirect()->route('admin.pengaturan.edit')
            ->with('success', 'Pengaturan website berhasil diperbarui.');
    }
}
