<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'nama_sekolah',
        'tagline',
        'alamat',
        'telepon',
        'email',
        'whatsapp',
        'jam_operasional',
        'akreditasi',
        'kepala_sekolah',
        'foto_kepala_sekolah',
        'sambutan',
        'visi',
        'misi',
        'sejarah',
        'jumlah_siswa',
        'jumlah_guru',
        'jumlah_kelas',
        'tahun_berdiri',
        'facebook',
        'instagram',
        'youtube',
        'maps_embed',
        'hero_image',
    ];

    protected function casts(): array
    {
        return [
            'jumlah_siswa' => 'integer',
            'jumlah_guru' => 'integer',
            'jumlah_kelas' => 'integer',
            'tahun_berdiri' => 'integer',
        ];
    }

    /**
     * Data pengaturan sekolah (baris pertama).
     * Bila tabel belum ada / belum di-seed, kembalikan nilai default agar website tetap tampil.
     */
    public static function current(): self
    {
        // Simpan di container (bukan static) agar cache hanya berlaku untuk
        // satu request dan otomatis bersih pada request berikutnya.
        if (app()->bound('site.setting')) {
            return app('site.setting');
        }

        try {
            $site = static::query()->first() ?? new static(static::defaults());
        } catch (\Throwable $e) {
            $site = new static(static::defaults());
        }

        app()->instance('site.setting', $site);

        return $site;
    }

    /**
     * Bersihkan cache pengaturan (dipakai setelah data diubah).
     */
    public static function forgetCurrent(): void
    {
        app()->forgetInstance('site.setting');
    }

    /**
     * Nilai default bila database belum siap.
     */
    public static function defaults(): array
    {
        return [
            'nama_sekolah' => 'SDN Lingkung',
            'tagline' => 'Membentuk Generasi Cerdas',
            'alamat' => 'Jl. Pendidikan No. 1, Desa Lingkung, Kabupaten Lombok Barat, Nusa Tenggara Barat',
            'telepon' => '(0370) 123456',
            'email' => 'info@sdnlingkung.sch.id',
            'whatsapp' => '6281234567890',
            'jam_operasional' => 'Senin – Sabtu, 07.00 – 14.00 WITA',
            'akreditasi' => 'A',
            'kepala_sekolah' => 'H. Ahmad Fauzan, S.Pd.',
            'jumlah_siswa' => 186,
            'jumlah_guru' => 12,
            'jumlah_kelas' => 6,
            'tahun_berdiri' => 1985,
            'maps_embed' => 'https://www.google.com/maps?q=SDN+Lingkung+Lombok+Barat&output=embed',
        ];
    }

    /**
     * Nomor WhatsApp dalam format internasional tanpa tanda +.
     */
    public function getWhatsappLinkAttribute(): string
    {
        $number = preg_replace('/\D/', '', (string) $this->whatsapp);

        if (str_starts_with($number, '0')) {
            $number = '62'.ltrim($number, '0');
        }

        return 'https://wa.me/'.$number;
    }
}
