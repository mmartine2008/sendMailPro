<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('envios_resultados', function (Blueprint $table) {
            // Add nullable error_message column
            $table->text('error_message')
                  ->nullable()
                  ->after('resultado'); // ajustá la posición si querés
        });
    }

    public function down()
    {
        Schema::table('envios_resultados', function (Blueprint $table) {
            $table->dropColumn('error_message');
        });
    }
};
