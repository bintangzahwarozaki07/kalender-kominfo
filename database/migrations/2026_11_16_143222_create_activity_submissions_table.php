<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_submissions', function (Blueprint $table) {
            $table->id();

            // Pemohon yang mengirim pengajuan
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete();

            // Kategori dan instansi kegiatan
            $table->foreignId('category_id')
                ->constrained('categories')
                ->restrictOnDelete();

            $table->foreignId('institution_id')
                ->constrained('institutions')
                ->restrictOnDelete();

            // Informasi kegiatan yang diajukan
            $table->string('title');
            $table->date('activity_date');
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable();
            $table->string('location')->nullable();
            $table->string('person_in_charge')->nullable();
            $table->text('description')->nullable();

            // Status pemeriksaan Administrator
            $table->string('status')->default('Menunggu');

            // Catatan dari Administrator
            $table->text('admin_note')->nullable();

            // Kegiatan resmi hasil persetujuan
            $table->foreignId('activity_id')
                ->nullable()
                ->constrained('activities')
                ->nullOnDelete();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_submissions');
    }
};
