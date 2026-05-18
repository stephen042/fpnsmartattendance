<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    
    protected $fillable = [
        'application_number',
        'reg_number',
        'full_name',
        'department',
        'level',
        'option',
        'email',

        // device security
        'device_hash',
        'device_user_agent',
        'device_screen_hash',
        'device_local_token',
        'device_locked_until',

        'last_ip',
        'last_login_at',
        'is_active',
        'meta'
    ];

    protected $casts = [
        'meta' => 'array',
        'device_locked' => 'boolean',
        'is_active' => 'boolean',
    ];
}
