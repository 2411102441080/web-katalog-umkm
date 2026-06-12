<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stores', function (Blueprint $col) {
            // Menghubungkan toko ke id pendaftar di tabel users
            $col->foreignId('user_id')->nullable()->constrained()->onDelete('cascade')->after('id');
            // Menambahkan status validasi oleh admin
            $col->string('status')->default('pending')->after('alamat'); // pending, active, rejected
        });
    }

    public function down(): void
    {
        Schema::table('stores', function (Blueprint $col) {
            $col->dropForeign(['user_id']);
            $col->dropColumn(['user_id', 'status']);
        });
    }
};