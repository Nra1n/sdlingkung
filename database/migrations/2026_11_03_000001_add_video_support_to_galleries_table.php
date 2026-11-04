<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('galleries', function (Blueprint $table) {
            $table->string('image')->nullable()->change();
            $table->string('video_url')->nullable()->after('image');
        });
    }

    public function down(): void
    {
        DB::table('galleries')
            ->whereNull('image')
            ->update(['image' => '']);

        Schema::table('galleries', function (Blueprint $table) {
            $table->dropColumn('video_url');
            $table->string('image')->nullable(false)->change();
        });
    }
};
