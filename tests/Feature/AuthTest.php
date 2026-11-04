<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login_from_admin_area(): void
    {
        $this->get('/admin')->assertRedirect(route('login'));
    }

    public function test_admin_can_login(): void
    {
        $admin = $this->admin();

        $response = $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    public function test_wrong_password_cannot_login(): void
    {
        $admin = $this->admin();

        $this->post(route('login.store'), [
            'email' => $admin->email,
            'password' => 'password-salah',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_non_admin_user_cannot_login(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->post(route('login.store'), [
            'email' => $user->email,
            'password' => 'password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    public function test_authenticated_non_admin_gets_forbidden_on_admin_routes(): void
    {
        $user = User::factory()->create(['is_admin' => false]);

        $this->actingAs($user)->get('/admin')->assertForbidden();
    }

    public function test_admin_can_open_all_admin_pages(): void
    {
        $admin = $this->admin();

        $pages = [
            '/admin',
            '/admin/berita',
            '/admin/berita/create',
            '/admin/guru',
            '/admin/guru/create',
            '/admin/galeri',
            '/admin/galeri/create',
            '/admin/prestasi',
            '/admin/prestasi/create',
            '/admin/pesan',
            '/admin/pengaturan',
        ];

        foreach ($pages as $page) {
            $this->actingAs($admin)->get($page)->assertOk();
        }
    }

    public function test_admin_can_logout(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post('/logout')
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    public function test_logged_in_admin_is_redirected_away_from_login_page(): void
    {
        $this->actingAs($this->admin())
            ->get('/login')
            ->assertRedirect(route('admin.dashboard'));
    }

    private function admin(): User
    {
        return User::factory()->create(['is_admin' => true]);
    }
}
