<?php

namespace Tests\Feature;

use App\Models\ContactMessage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactFormTest extends TestCase
{
    use RefreshDatabase;

    public function test_valid_message_is_saved(): void
    {
        $response = $this->post(route('kontak.store'), [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'phone' => '081234567890',
            'subject' => 'Informasi PPDB',
            'message' => 'Mohon informasi syarat pendaftaran peserta didik baru.',
        ]);

        $response->assertRedirect(route('kontak'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'name' => 'Budi Santoso',
            'email' => 'budi@example.com',
            'subject' => 'Informasi PPDB',
            'is_read' => false,
        ]);
    }

    public function test_required_fields_are_validated(): void
    {
        $this->post(route('kontak.store'), [])
            ->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_invalid_email_and_short_message_are_rejected(): void
    {
        $this->post(route('kontak.store'), [
            'name' => 'Budi',
            'email' => 'bukan-email',
            'subject' => 'Tes',
            'message' => 'pendek',
        ])->assertSessionHasErrors(['email', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_validation_messages_are_in_indonesian(): void
    {
        $this->post(route('kontak.store'), [
            'name' => '',
            'email' => '',
            'subject' => '',
            'message' => '',
        ]);

        $this->get(route('kontak'))
            ->assertOk()
            ->assertSee('wajib diisi');
    }

    public function test_honeypot_field_blocks_spam_without_saving(): void
    {
        $this->post(route('kontak.store'), [
            'website' => 'http://spam.example',
            'name' => 'Robot',
            'email' => 'robot@example.com',
            'subject' => 'Spam',
            'message' => 'Pesan spam yang tidak boleh tersimpan di database.',
        ])->assertRedirect(route('kontak'));

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_message_appears_in_admin_inbox(): void
    {
        ContactMessage::create([
            'name' => 'Siti Aminah',
            'email' => 'siti@example.com',
            'subject' => 'Pertanyaan Jadwal',
            'message' => 'Kapan jadwal pendaftaran dibuka kembali?',
        ]);

        $this->actingAs(\App\Models\User::factory()->create(['is_admin' => true]))
            ->get(route('admin.pesan.index'))
            ->assertOk()
            ->assertSee('Siti Aminah')
            ->assertSee('Pertanyaan Jadwal');
    }
}
