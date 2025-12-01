<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cuentas', function (Blueprint $table) {
            // Agregá aquí las columnas que quieras volver nullable
            $table->string('nombre')->nullable()->change();
            $table->string('password')->nullable()->change();
            // ...agregar más campos según tu tabla...
        });
    }

    public function down(): void
    {
        Schema::table('cuentas', function (Blueprint $table) {

            $table->string('nombre')->nullable(false)->change();
            $table->string('email')->nullable(false)->change();
            $table->decimal('saldo')->nullable(false)->change();
            $table->integer('usuario_id')->nullable(false)->change();

        });
    }
};
