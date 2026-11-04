<?php

namespace Tests\Feature;

use App\Models\Gallery;
use App\Models\News;
use App\Models\SiteSetting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PublicPagesTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_is_accessible(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('SDN Lingkung')
            ->assertSee('Membentuk Generasi Cerdas')
            ->assertSee('SD NEGERI LINGKUNG')
            ->assertSee('SD Negeri Lingkung berkomitmen menyelenggarakan pendidikan dasar yang berkualitas,');
    }

    public function test_home_page_uses_tagline_from_site_settings(): void
    {
        SiteSetting::create([
            'nama_sekolah' => 'SDN Lingkung',
            'tagline' => 'Belajar Tumbuh Bersama',
        ]);

        $this->get('/')
            ->assertOk()
            ->assertSee('Belajar Tumbuh Bersama')
            ->assertSee('SD NEGERI LINGKUNG')
            ->assertDontSee('Membentuk Generasi Cerdas');
    }

    public function test_profil_page_shows_school_profile(): void
    {
        $this->get('/profil')
            ->assertOk()
            ->assertSee('Profil Sekolah')
            ->assertSee('Visi');
    }

    public function test_berita_index_lists_published_news(): void
    {
        $news = $this->publishedNews(['title' => 'Berita Tayang untuk Pengujian']);

        $this->get('/berita')
            ->assertOk()
            ->assertSee($news->title);
    }

    public function test_unpublished_news_is_hidden_from_index(): void
    {
        $news = $this->publishedNews([
            'title' => 'Berita Masih Draf',
            'is_published' => false,
        ]);

        $this->get('/berita')
            ->assertOk()
            ->assertDontSee($news->title);
    }

    public function test_berita_detail_is_accessible_by_slug_and_counts_view(): void
    {
        $news = $this->publishedNews(['title' => 'Detail Berita Pengujian']);

        $this->get('/berita/'.$news->slug)
            ->assertOk()
            ->assertSee($news->title);

        $this->assertDatabaseHas('news', [
            'id' => $news->id,
            'views' => 1,
        ]);
    }

    public function test_unpublished_news_detail_returns_not_found(): void
    {
        $news = $this->publishedNews([
            'title' => 'Draf Tidak Boleh Dibuka',
            'is_published' => false,
        ]);

        $this->get('/berita/'.$news->slug)->assertNotFound();
    }

    public function test_galeri_page_lists_photos_before_youtube_videos(): void
    {
        $photo = Gallery::create([
            'title' => 'Foto Kegiatan Pengujian',
            'category' => 'Kegiatan',
            'image' => 'images/seed/sekolah.jpg',
            'is_published' => true,
        ]);

        $video = Gallery::create([
            'title' => 'Video Kegiatan Pengujian',
            'category' => 'Kegiatan',
            'video_url' => 'https://youtu.be/abcdefghijk',
            'is_published' => true,
        ]);

        $this->get('/galeri')
            ->assertOk()
            ->assertSeeInOrder([$photo->title, $video->title])
            ->assertSee('https://www.youtube.com/embed/abcdefghijk')
            ->assertSee('https://i.ytimg.com/vi/abcdefghijk/hqdefault.jpg')
            ->assertSee('Foto')
            ->assertSee('Video');
    }

    public function test_kontak_page_is_accessible(): void
    {
        $this->get('/kontak')
            ->assertOk()
            ->assertSee('Hubungi Kami')
            ->assertSee('Formulir Pesan');
    }

    public function test_sitemap_is_valid_xml(): void
    {
        $this->publishedNews(['title' => 'Berita di Sitemap']);

        $response = $this->get('/sitemap.xml');

        $response->assertOk();
        $response->assertHeader('Content-Type', 'application/xml');
        $response->assertSee('<urlset', false);
    }

    public function test_robots_txt_blocks_admin_area(): void
    {
        $this->get('/robots.txt')
            ->assertOk()
            ->assertSee('Disallow: /admin')
            ->assertSee('Sitemap:');
    }

    public function test_unknown_page_returns_custom_404(): void
    {
        $this->get('/halaman-yang-tidak-ada')
            ->assertNotFound()
            ->assertSee('Halaman Tidak Ditemukan');
    }

    public function test_site_setting_defaults_are_used_when_database_is_empty(): void
    {
        $this->assertDatabaseCount('site_settings', 0);

        $site = SiteSetting::current();

        $this->assertSame('SDN Lingkung', $site->nama_sekolah);
        $this->assertSame('https://wa.me/6281234567890', $site->whatsapp_link);
    }

    /**
     * @param  array<string, mixed>  $attributes
     */
    private function publishedNews(array $attributes = []): News
    {
        return News::create(array_merge([
            'title' => 'Judul Berita Pengujian',
            'slug' => 'judul-berita-pengujian',
            'category' => 'Umum',
            'excerpt' => 'Ringkasan berita pengujian.',
            'content' => 'Isi berita pengujian yang cukup panjang untuk ditampilkan pada halaman detail berita sekolah.',
            'is_published' => true,
            'published_at' => now()->subDay(),
        ], $attributes));
    }
}
