<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('cuentas', function (Blueprint $table) {
            // Add boolean flag
            $table->boolean('enviado')
                ->default(false)
                ->after('activa'); // adjust position if needed
        });
    }

    public function down()
    {
        Schema::table('cuentas', function (Blueprint $table) {
            $table->dropColumn('enviado');
        });
    }
};
