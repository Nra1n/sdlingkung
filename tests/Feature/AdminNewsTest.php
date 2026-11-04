<?php

namespace Tests\Feature;

use App\Models\News;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class AdminNewsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_manage_news(): void
    {
        $this->get(route('admin.berita.index'))->assertRedirect(route('login'));
        $this->post(route('admin.berita.store'), [])->assertRedirect(route('login'));
    }

    public function test_admin_can_create_news(): void
    {
        $admin = $this->admin();

        $response = $this->actingAs($admin)->post(route('admin.berita.store'), [
            'title' => 'Penerimaan Siswa Baru 2026',
            'category' => 'PPDB',
            'excerpt' => 'Pendaftaran telah dibuka.',
            'content' => str_repeat('Isi berita yang cukup panjang untuk lolos validasi. ', 2),
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.berita.index'));

        $news = News::first();
        $this->assertNotNull($news);
        $this->assertSame('penerimaan-siswa-baru-2026', $news->slug);
        $this->assertSame($admin->id, $news->user_id);
        $this->assertTrue($news->is_published);
        $this->assertNotNull($news->published_at);
    }

    public function test_admin_can_create_news_with_image_upload(): void
    {
        $before = $this->uploadedFiles();

        try {
            $this->actingAs($this->admin())->post(route('admin.berita.store'), [
                'title' => 'Berita dengan Gambar',
                'category' => 'Kegiatan',
                'content' => str_repeat('Isi berita bergambar yang cukup panjang. ', 2),
                'is_published' => '1',
                'image' => $this->fakeImageUpload(),
            ])->assertRedirect(route('admin.berita.index'));

            $news = News::first();
            $this->assertNotNull($news);
            $this->assertStringStartsWith('uploads/berita/', $news->image);
            $this->assertFileExists(public_path($news->image));
        } finally {
            $this->deleteNewUploads($before);
        }
    }

    public function test_admin_can_update_news_and_slug_is_regenerated(): void
    {
        $news = $this->existingNews();
        $admin = $this->admin();

        $response = $this->actingAs($admin)->put(route('admin.berita.update', $news), [
            'title' => 'Judul Berita Setelah Diubah',
            'category' => 'Pengumuman',
            'excerpt' => 'Ringkasan baru.',
            'content' => str_repeat('Isi berita setelah perubahan yang cukup panjang. ', 2),
            'is_published' => '1',
        ]);

        $response->assertRedirect(route('admin.berita.index'));

        $news->refresh();
        $this->assertSame('Judul Berita Setelah Diubah', $news->title);
        $this->assertSame('judul-berita-setelah-diubah', $news->slug);
        $this->assertSame('Pengumuman', $news->category);
    }

    public function test_admin_can_delete_news(): void
    {
        $news = $this->existingNews();

        $this->actingAs($this->admin())
            ->delete(route('admin.berita.destroy', $news))
            ->assertRedirect(route('admin.berita.index'));

        $this->assertDatabaseMissing('news', ['id' => $news->id]);
    }

    public function test_deleting_news_removes_its_uploaded_image(): void
    {
        $path = 'uploads/berita/uji-hapus.jpg';
        @mkdir(dirname(public_path($path)), 0755, true);
        file_put_contents(public_path($path), 'gambar uji');

        try {
            $news = News::create([
                'title' => 'Berita dengan Gambar Uji',
                'slug' => 'berita-dengan-gambar-uji',
                'category' => 'Umum',
                'content' => 'Isi berita pengujian penghapusan gambar.',
                'image' => $path,
                'is_published' => true,
                'published_at' => now(),
            ]);

            $this->actingAs($this->admin())
                ->delete(route('admin.berita.destroy', $news))
                ->assertRedirect(route('admin.berita.index'));

            $this->assertFileDoesNotExist(public_path($path));
            $this->assertDatabaseMissing('news', ['id' => $news->id]);
        } finally {
            @unlink(public_path($path));
        }
    }

    public function test_news_validation_rejects_invalid_input(): void
    {
        $this->actingAs($this->admin())->post(route('admin.berita.store'), [
            'title' => '',
            'category' => 'Kategori Tidak Ada',
            'content' => 'pendek',
        ])->assertSessionHasErrors(['title', 'category', 'content']);

        $this->assertDatabaseCount('news', 0);
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }

    private function existingNews(): News
    {
        return News::create([
            'title' => 'Judul Berita Awal',
            'slug' => 'judul-berita-awal',
            'category' => 'Umum',
            'excerpt' => 'Ringkasan awal.',
            'content' => str_repeat('Isi berita awal yang cukup panjang. ', 2),
            'is_published' => true,
            'published_at' => now()->subDay(),
        ]);
    }

    private function fakeImageUpload(): UploadedFile
    {
        $path = tempnam(sys_get_temp_dir(), 'sdnimg');
        copy(public_path('images/seed/sekolah.jpg'), $path);

        return new UploadedFile($path, 'sekolah.jpg', 'image/jpeg', null, true);
    }

    /**
     * @return list<string>
     */
    private function uploadedFiles(): array
    {
        return glob(public_path('uploads/*/*')) ?: [];
    }

    /**
     * Hapus hanya file baru yang dibuat selama pengujian.
     *
     * @param  list<string>  $before
     */
    private function deleteNewUploads(array $before): void
    {
        foreach (array_diff($this->uploadedFiles(), $before) as $file) {
            @unlink($file);
        }
    }
}
