<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Menambahkan role pemohon tanpa menghapus role lama.
     */
    public function up(): void
    {
        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'dokter',
                'pasien',
                'pemohon'
            ) NOT NULL DEFAULT 'pasien'
        ");
    }

    /**
     * Rollback hanya diperbolehkan jika belum ada pemohon.
     */
    public function down(): void
    {
        $jumlahPemohon = DB::table('users')
            ->where('role', 'pemohon')
            ->count();

        if ($jumlahPemohon > 0) {
            throw new RuntimeException(
                'Tidak dapat menghapus role pemohon karena masih digunakan.'
            );
        }

        DB::statement("
            ALTER TABLE users
            MODIFY role ENUM(
                'admin',
                'dokter',
                'pasien'
            ) NOT NULL DEFAULT 'pasien'
        ");
    }
};
