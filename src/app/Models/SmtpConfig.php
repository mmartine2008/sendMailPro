<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmtpConfig extends Model
{
    protected $table = 'smtp_table';
    // Mass assignable fields
    protected $fillable = [
        'host',
        'smtp_auth',
        'username',
        'password',
        'encryption',
        'port',
        'is_html',
    ];
}
