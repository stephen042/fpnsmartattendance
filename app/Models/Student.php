<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{

    protected $fillable = [
        'application_number',
        'matric_number',
        'full_name',
        'email',
        'phone',
        'gender',
        'department_id',
        'level_id',
        'programme_id',
        'course_option_id',
        'password',
        'device_hash',
        'device_name',
        'device_user_agent',
        'device_screen_hash',
        'device_local_token',
        'device_locked',
        'device_locked_until',
        'last_ip',
        'last_login_at',
        'is_active',
        'meta',
    ];

    protected $casts = [
        'meta' => 'array',
        'device_locked' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function programme()
    {
        return $this->belongsTo(Programme::class);
    }

    public function department()
    {
        return $this->belongsTo(Department::class);
    }

    public function courseOption()
    {
        return $this->belongsTo(CourseOption::class);
    }
}
