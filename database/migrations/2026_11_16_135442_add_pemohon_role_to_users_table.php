<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Menambahkan role jika belum tersedia,
     * atau memperbarui enum jika kolom sudah tersedia.
     */
    public function up(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            DB::statement("
                ALTER TABLE users
                ADD role ENUM(
                    'admin',
                    'dokter',
                    'pasien',
                    'pemohon'
                ) NOT NULL DEFAULT 'pasien'
            ");
        } else {
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
    }

    /**
     * Mengembalikan daftar role lama tanpa menghapus
     * kolom maupun data pengguna.
     */
    public function down(): void
    {
        if (!Schema::hasColumn('users', 'role')) {
            return;
        }

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
