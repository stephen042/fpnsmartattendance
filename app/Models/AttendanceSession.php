<?php

namespace App\Models;

use App\Models\AttendanceRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AttendanceSession extends Model
{
    protected $fillable = ['course_id', 'lecturer_id', 'academic_session_id', 'semester_id', 'attendance_code', 'started_at', 'ended_at', 'is_active', 'expected_students'];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function records(): HasMany
    {
        return $this->hasMany(AttendanceRecord::class, 'attendance_session_id');
    }
}
