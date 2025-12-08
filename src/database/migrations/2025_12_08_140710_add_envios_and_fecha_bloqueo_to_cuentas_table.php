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
        Schema::table('cuentas', function (Blueprint $table) {
            // Add integer column for number of sent items
            $table->integer('envios')->default(0);

            // Add datetime column for lock date
            $table->dateTime('fecha_bloqueo')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('cuentas', function (Blueprint $table) {
            $table->dropColumn('envios');
            $table->dropColumn('fecha_bloqueo');
        });
    }
};
