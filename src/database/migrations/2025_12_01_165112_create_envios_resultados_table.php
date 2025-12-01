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
        Schema::create('envios_resultados', function (Blueprint $table) {
            $table->id();

            // Email account (foreign key to cuentas)
            $table->foreignId('cuenta_id')
                  ->constrained('cuentas')
                  ->restrictOnDelete()
                  ->restrictOnUpdate();

            // DateTime of sending
            $table->dateTime('fecha_envio')->nullable();

            // Result of sending (ok, error, etc)
            $table->string('resultado', 255)->nullable();

            // Foreign key to mensajes_programados
            $table->foreignId('programacion_id')
                  ->constrained('mensajes_programados')
                  ->restrictOnDelete()
                  ->restrictOnUpdate();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('envios_resultados');
    }
};
