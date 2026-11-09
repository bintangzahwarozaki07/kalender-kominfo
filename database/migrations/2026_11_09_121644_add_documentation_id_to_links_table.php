
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->foreignId('documentation_id')
                ->nullable()
                ->after('activity_id')
                ->constrained('documentations')
                ->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('links', function (Blueprint $table) {
            $table->dropForeign(['documentation_id']);
            $table->dropColumn('documentation_id');
        });
    }
};
