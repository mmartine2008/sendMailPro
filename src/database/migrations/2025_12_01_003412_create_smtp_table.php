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
        Schema::create('smtp_table', function (Blueprint $table) {
            $table->id();

            // SMTP server configuration
            $table->string('host')->default('smtp.gmail.com'); // SMTP host
            $table->boolean('smtp_auth')->default(true);       // Enables SMTP authentication
            $table->string('username');                        // Email username
            $table->string('password');                        // Email password or app password
            $table->string('encryption')->default('tls');      // Encryption type (tls/ssl)
            $table->integer('port')->default(587);             // SMTP port
            $table->boolean('is_html')->default(true);         // Send HTML emails

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('smtp_table');
    }
};
