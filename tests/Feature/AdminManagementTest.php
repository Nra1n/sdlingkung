<?php

namespace Tests\Feature;

use App\Models\Achievement;
use App\Models\ContactMessage;
use App\Models\Gallery;
use App\Models\SiteSetting;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_create_update_and_delete_teacher(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.guru.store'), [
            'name' => 'Guru Pengujian, S.Pd.',
            'position' => 'Guru Kelas',
            'subject' => 'Kelas III',
            'order' => 5,
            'is_active' => '1',
        ])->assertRedirect(route('admin.guru.index'));

        $teacher = Teacher::first();
        $this->assertNotNull($teacher);
        $this->assertSame('Guru Pengujian, S.Pd.', $teacher->name);
        $this->assertTrue($teacher->is_active);

        $this->actingAs($admin)->put(route('admin.guru.update', $teacher), [
            'name' => 'Guru Pengujian Diubah, S.Pd.',
            'position' => 'Guru Mata Pelajaran',
            'subject' => 'PJOK',
            'order' => 2,
            'is_active' => '1',
        ])->assertRedirect(route('admin.guru.index'));

        $this->assertSame('Guru Pengujian Diubah, S.Pd.', $teacher->fresh()->name);

        $this->actingAs($admin)
            ->delete(route('admin.guru.destroy', $teacher))
            ->assertRedirect(route('admin.guru.index'));

        $this->assertDatabaseMissing('teachers', ['id' => $teacher->id]);
    }

    public function test_teacher_validation_requires_name_and_position(): void
    {
        $this->actingAs($this->admin())->post(route('admin.guru.store'), [
            'name' => '',
            'position' => '',
        ])->assertSessionHasErrors(['name', 'position']);
    }

    public function test_gallery_requires_photo_or_video_content_on_create(): void
    {
        $this->actingAs($this->admin())->post(route('admin.galeri.store'), [
            'title' => 'Konten Tanpa Media',
            'category' => 'Kegiatan',
            'media_type' => 'photo',
            'is_published' => '1',
        ])->assertSessionHasErrors('image');

        $this->assertDatabaseCount('galleries', 0);
    }

    public function test_admin_gallery_form_offers_photo_and_youtube_video_content(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.galeri.create'))
            ->assertOk()
            ->assertSee('Tambah Konten')
            ->assertSee('Jenis Konten')
            ->assertSee('Link Video YouTube');
    }

    public function test_admin_can_create_youtube_video_gallery_content(): void
    {
        $this->actingAs($this->admin())->post(route('admin.galeri.store'), [
            'media_type' => 'video',
            'title' => 'Video Kegiatan Pengujian',
            'category' => 'Kegiatan',
            'video_url' => 'https://youtu.be/abcdefghijk',
            'is_published' => '1',
        ])->assertRedirect(route('admin.galeri.index'));

        $this->assertDatabaseHas('galleries', [
            'title' => 'Video Kegiatan Pengujian',
            'image' => null,
            'video_url' => 'https://youtu.be/abcdefghijk',
            'is_published' => true,
        ]);
    }

    public function test_gallery_rejects_non_youtube_video_links(): void
    {
        $this->actingAs($this->admin())->post(route('admin.galeri.store'), [
            'media_type' => 'video',
            'title' => 'Video Link Tidak Valid',
            'category' => 'Kegiatan',
            'video_url' => 'https://example.com/watch?v=abcdefghijk',
        ])->assertSessionHasErrors('video_url');

        $this->assertDatabaseCount('galleries', 0);
    }

    public function test_admin_can_update_gallery_without_replacing_image(): void
    {
        $gallery = Gallery::create([
            'title' => 'Foto Awal',
            'category' => 'Kegiatan',
            'image' => 'images/seed/sekolah.jpg',
            'is_published' => true,
        ]);

        $this->actingAs($this->admin())->put(route('admin.galeri.update', $gallery), [
            'media_type' => 'photo',
            'title' => 'Foto Setelah Diubah',
            'category' => 'Fasilitas',
            'description' => 'Keterangan baru.',
            'is_published' => '1',
        ])->assertRedirect(route('admin.galeri.index'));

        $gallery->refresh();
        $this->assertSame('Foto Setelah Diubah', $gallery->title);
        $this->assertSame('images/seed/sekolah.jpg', $gallery->image);
    }

    public function test_admin_can_change_photo_gallery_content_to_youtube_video(): void
    {
        $gallery = Gallery::create([
            'title' => 'Konten Awal',
            'category' => 'Kegiatan',
            'image' => 'images/seed/sekolah.jpg',
            'is_published' => true,
        ]);

        $this->actingAs($this->admin())->put(route('admin.galeri.update', $gallery), [
            'media_type' => 'video',
            'title' => 'Konten Video',
            'category' => 'Kegiatan',
            'video_url' => 'https://www.youtube.com/watch?v=abcdefghijk',
            'is_published' => '1',
        ])->assertRedirect(route('admin.galeri.index'));

        $this->assertDatabaseHas('galleries', [
            'id' => $gallery->id,
            'image' => null,
            'video_url' => 'https://www.youtube.com/watch?v=abcdefghijk',
        ]);
    }

    public function test_admin_can_create_and_delete_achievement(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.prestasi.store'), [
            'title' => 'Juara 1 Lomba Pengujian',
            'level' => 'Kabupaten',
            'year' => 2026,
            'description' => 'Prestasi hasil pengujian otomatis.',
            'is_published' => '1',
        ])->assertRedirect(route('admin.prestasi.index'));

        $achievement = Achievement::first();
        $this->assertNotNull($achievement);
        $this->assertSame('Kabupaten', $achievement->level);

        $this->actingAs($admin)
            ->delete(route('admin.prestasi.destroy', $achievement))
            ->assertRedirect(route('admin.prestasi.index'));

        $this->assertDatabaseMissing('achievements', ['id' => $achievement->id]);
    }

    public function test_opening_message_marks_it_as_read(): void
    {
        $message = ContactMessage::create([
            'name' => 'Pengirim Uji',
            'email' => 'pengirim@example.com',
            'subject' => 'Subjek Uji',
            'message' => 'Isi pesan pengujian yang cukup panjang.',
        ]);

        $this->assertFalse((bool) $message->fresh()->is_read);

        $this->actingAs($this->admin())
            ->get(route('admin.pesan.show', $message))
            ->assertOk()
            ->assertSee('Subjek Uji');

        $this->assertTrue($message->fresh()->is_read);
    }

    public function test_admin_can_delete_message(): void
    {
        $message = ContactMessage::create([
            'name' => 'Pengirim Uji',
            'email' => 'pengirim@example.com',
            'subject' => 'Subjek Uji',
            'message' => 'Isi pesan pengujian yang cukup panjang.',
        ]);

        $this->actingAs($this->admin())
            ->delete(route('admin.pesan.destroy', $message))
            ->assertRedirect(route('admin.pesan.index'));

        $this->assertDatabaseMissing('contact_messages', ['id' => $message->id]);
    }

    public function test_admin_can_update_site_settings(): void
    {
        $this->actingAs($this->admin())->put(route('admin.pengaturan.update'), [
            'nama_sekolah' => 'SDN Lingkung Baru',
            'tagline' => 'Tagline baru sekolah.',
            'email' => 'baru@sdnlingkung.sch.id',
            'whatsapp' => '628111222333',
            'jumlah_siswa' => 200,
            'jumlah_guru' => 15,
            'jumlah_kelas' => 6,
            'tahun_berdiri' => 1985,
            'facebook' => 'https://facebook.com/sdnlingkung',
            'maps_embed' => '<iframe src="https://www.google.com/maps/embed?pb=contoh" width="600"></iframe>',
        ])->assertRedirect(route('admin.pengaturan.edit'));

        $this->assertDatabaseHas('site_settings', [
            'nama_sekolah' => 'SDN Lingkung Baru',
            'jumlah_siswa' => 200,
            'maps_embed' => 'https://www.google.com/maps/embed?pb=contoh',
        ]);

        $this->get('/')->assertOk()->assertSee('SDN Lingkung Baru');
    }

    public function test_site_settings_validation_rejects_invalid_url(): void
    {
        $this->actingAs($this->admin())->put(route('admin.pengaturan.update'), [
            'nama_sekolah' => 'SDN Lingkung',
            'facebook' => 'bukan-url',
        ])->assertSessionHasErrors('facebook');
    }

    public function test_admin_can_upload_and_remove_hero_background_image(): void
    {
        $path = tempnam(sys_get_temp_dir(), 'heroimg');
        copy(public_path('images/seed/hero.jpg'), $path);

        $this->actingAs($this->admin())->put(route('admin.pengaturan.update'), [
            'nama_sekolah' => 'SDN Lingkung',
            'hero_image' => new UploadedFile($path, 'hero.jpg', 'image/jpeg', null, true),
        ])->assertRedirect(route('admin.pengaturan.edit'));

        $uploaded = SiteSetting::current()->hero_image;

        $this->assertNotNull($uploaded);
        $this->assertStringStartsWith('uploads/sekolah/', $uploaded);
        $this->assertFileExists(public_path($uploaded));
        $this->get('/')->assertOk()->assertSee($uploaded);

        $this->actingAs($this->admin())->put(route('admin.pengaturan.update'), [
            'nama_sekolah' => 'SDN Lingkung',
            'hapus_hero_image' => '1',
        ])->assertRedirect(route('admin.pengaturan.edit'));

        $this->assertNull(SiteSetting::current()->hero_image);
        $this->assertFileDoesNotExist(public_path($uploaded));
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
