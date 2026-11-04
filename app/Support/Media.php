<?php

namespace App\Support;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

class Media
{
    /**
     * Folder penyimpanan gambar di dalam public/uploads.
     */
    public const UPLOAD_DIR = 'uploads';

    /**
     * Simpan file upload ke public/uploads/{folder}.
     * Mengembalikan path relatif, contoh: uploads/berita/abc123.jpg
     */
    public static function store(UploadedFile $file, string $folder = 'umum'): string
    {
        $folder = trim($folder, '/');
        $directory = public_path(self::UPLOAD_DIR.'/'.$folder);

        if (! is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        $name = date('YmdHis').'-'.Str::random(8).'.'.strtolower($file->getClientOriginalExtension());
        $file->move($directory, $name);

        return self::UPLOAD_DIR.'/'.$folder.'/'.$name;
    }

    /**
     * Hapus gambar lama. URL eksternal dan gambar bawaan (images/seed) tidak dihapus.
     */
    public static function delete(?string $path): void
    {
        if (blank($path) || Str::startsWith($path, ['http://', 'https://', 'images/'])) {
            return;
        }

        $fullPath = public_path($path);

        if (is_file($fullPath)) {
            @unlink($fullPath);
        }
    }

    /**
     * Ubah path di database menjadi URL yang bisa dipakai <img src="...">.
     */
    public static function url(?string $path, string $fallback = 'images/placeholder.svg'): string
    {
        if (blank($path)) {
            return asset($fallback);
        }

        if (Str::startsWith($path, ['http://', 'https://'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}
