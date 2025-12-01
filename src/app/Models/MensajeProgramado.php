<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MensajeProgramado extends Model
{
    use HasFactory;

    protected $table = 'mensajes_programados';

    protected $fillable = [
        'start_date',
        'end_date',
        'subject',
        'body',
    ];
}
