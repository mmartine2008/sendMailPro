<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cuentas', function (Blueprint $table) {
            // Add foreign key
            $table->foreignId('smtp_id')
                ->constrained('smtp_table')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('cuentas', function (Blueprint $table) {
            $table->dropForeign(['smtp_id']);
            $table->dropColumn('smtp_id');
        });
    }
};
