<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentDevice extends Model
{
    protected $fillable = [
        'student_id',
        'device_hash',
        'device_name',
        'device_screen_hash',
        'device_user_agent',
        'device_local_token',
        'last_ip',
        'last_login_at',
    ];

    protected $casts = ['last_login_at' => 'datetime',];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
