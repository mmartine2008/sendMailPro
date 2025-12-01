<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Cuenta;
use App\Models\SmtpConfig;

class CuentasSeeder extends Seeder
{
    public function run(): void
    {
        // First SMTP record (example)
        $smtp = SmtpConfig::first();

        if (!$smtp) {
            return; // Prevent error if no SMTP exists
        }

        Cuenta::create([
            'nombre'   => 'softwarehuella@gmail.com',
            'password' => 'whdhhxtxklwtedug',
            'smtp_id'  => $smtp->id
        ]);
    }
}
