<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    protected $fillable = [
        'session',
        'semester',
        'ip_config',
        'departments'
    ];

    protected $casts = [
        'ip_config' => 'array',
        'departments' => 'array',
    ];
}