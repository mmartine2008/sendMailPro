<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SmtpConfig;

class SmtpSeeder extends Seeder
{
    public function run(): void
    {
        SmtpConfig::create([
            'host' => 'smtp.gmail.com',
            'smtp_auth' => true,
            'username' => 'example@gmail.com',
            'password' => 'app_password',
            'encryption' => 'tls',
            'port' => 587,
            'is_html' => true,
        ]);
    }
}
