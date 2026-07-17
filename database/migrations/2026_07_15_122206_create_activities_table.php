<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table) {

            $table->id();

            // Relasi ke kategori
            $table->foreignId('category_id')
                ->constrained()
                ->cascadeOnDelete();

            // Relasi ke instansi
            $table->foreignId('institution_id')
                ->constrained()
                ->cascadeOnDelete();

            // Informasi kegiatan
            $table->string('title', 200);
            $table->string('slug')->unique();

            // Jadwal kegiatan
            $table->date('activity_date');
            $table->date('publish_date')->nullable();
            $table->time('start_time');
            $table->time('end_time');

            // Lokasi
            $table->string('location');

            // Penanggung jawab
            $table->string('person_in_charge');

            // Deskripsi
            $table->text('description')->nullable();

            // Thumbnail
            $table->string('thumbnail')->nullable();

            // Status
            $table->enum('status', [
                'Draft',
                'Terjadwal',
                'Dipublikasikan',
                'Selesai'
            ])->default('Draft');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};