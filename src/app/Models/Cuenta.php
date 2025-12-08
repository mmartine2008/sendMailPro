<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SmtpConfig;

class Cuenta extends Model
{
    use HasFactory;

    protected $table = 'cuentas';

    protected $fillable = [
        'nombre',
        'password',
        'smtp_id',
        'activa'
    ];

    public function smtpConfig()
    {
        return $this->belongsTo(SmtpConfig::class, 'smtp_id');
    }
}
