<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceSession extends Model
{
    protected $fillable = ['course_id', 'lecturer_id', 'academic_session_id', 'semester_id', 'attendance_code', 'started_at', 'ended_at', 'is_active', 'expected_students'];
    
    public function records()
    {
        return $this->hasMany(AttendanceRecord::class);
    }
}
