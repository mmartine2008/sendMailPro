<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Cuenta;
use App\Models\MensajeProgramado;

class EnvioResultado extends Model
{
    use HasFactory;

    protected $table = 'envios_resultados';

    protected $fillable = [
        'cuenta_id',
        'fecha_envio',
        'resultado',
        'programacion_id',
    ];

    // Relationship to Cuenta
    public function cuenta()
    {
        return $this->belongsTo(Cuenta::class);
    }

    // Relationship to mensajes_programados
    public function programacion()
    {
        return $this->belongsTo(MensajeProgramado::class, 'programacion_id');
    }
}
