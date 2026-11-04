<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('nama_sekolah')->default('SDN Lingkung');
            $table->string('tagline')->nullable();
            $table->text('alamat')->nullable();
            $table->string('telepon', 50)->nullable();
            $table->string('email')->nullable();
            $table->string('whatsapp', 30)->nullable();
            $table->string('jam_operasional')->nullable();
            $table->string('akreditasi', 10)->nullable();
            $table->string('kepala_sekolah')->nullable();
            $table->string('foto_kepala_sekolah')->nullable();
            $table->text('sambutan')->nullable();
            $table->text('visi')->nullable();
            $table->text('misi')->nullable();
            $table->text('sejarah')->nullable();
            $table->unsignedInteger('jumlah_siswa')->default(0);
            $table->unsignedInteger('jumlah_guru')->default(0);
            $table->unsignedInteger('jumlah_kelas')->default(0);
            $table->unsignedInteger('tahun_berdiri')->nullable();
            $table->string('facebook')->nullable();
            $table->string('instagram')->nullable();
            $table->string('youtube')->nullable();
            $table->text('maps_embed')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
