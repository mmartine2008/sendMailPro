<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('smtp_table', function (Blueprint $table) {

            // Ejemplos típicos de una tabla SMTP:
            $table->string('host')->nullable()->change();
            $table->integer('smtp_auth')->nullable()->change();
            $table->string('username')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('encryption')->nullable()->change();
            $table->integer('port')->nullable()->change();
            $table->integer('is_html')->nullable()->change();

            // Agregá todas las columnas que tenga tu tabla
        });
    }

    public function down(): void
    {
        Schema::table('smtp_config', function (Blueprint $table) {
            $table->string('host')->nullable()->change();
            $table->integer('smtp_auth')->nullable()->change();
            $table->string('username')->nullable()->change();
            $table->string('password')->nullable()->change();
            $table->string('encryption')->nullable()->change();
            $table->integer('port')->nullable()->change();
            $table->integer('is_html')->nullable()->change();

            // Mismas columnas que arriba
        });
    }
};
