
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->string('letter_number')->nullable();
            $table->string('letter_attachment')->nullable();
            $table->string('letter_recipient')->nullable();
            $table->date('letter_date')->nullable();
            $table->string('signatory_position')->nullable();
            $table->string('signatory_name')->nullable();
            $table->string('signatory_nip')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('activities', function (Blueprint $table) {
            $table->dropColumn([
                'letter_number',
                'letter_attachment',
                'letter_recipient',
                'letter_date',
                'signatory_position',
                'signatory_name',
                'signatory_nip',
            ]);
        });
    }
};
