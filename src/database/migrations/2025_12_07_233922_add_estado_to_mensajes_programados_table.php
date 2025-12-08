<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('mensajes_programados', function (Blueprint $table) {
            $table->unsignedTinyInteger('estado')
                ->default(0)
                ->comment('0=Sin iniciar, 1=Iniciado, 2=Terminado');
        });
    }

    public function down(): void
    {
        Schema::table('mensajes_programados', function (Blueprint $table) {
            $table->dropColumn('estado');
        });
    }
};
