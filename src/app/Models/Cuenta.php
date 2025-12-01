<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\SmtpConfig;

class Cuenta extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'password',
        'smtp_id',
        'activa'
    ];

    // Relationship: each account belongs to one smtp
    public function smtp()
    {
        return $this->belongsTo(SmtpConfig::class, 'smtp_id');
    }
}
