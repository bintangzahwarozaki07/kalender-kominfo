<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('documentations', function (Blueprint $table) {

        $table->id();

        $table->foreignId('activity_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('photo');

        $table->string('caption')->nullable();

        $table->boolean('is_cover')->default(false);

        $table->timestamps();

    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documentations');
    }
};