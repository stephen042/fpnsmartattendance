<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Course extends Model
{
    protected $fillable = [
        'course_name',
        'course_code',
        'course_type',
        'department_id',
        'semester_id',
        'level_id',
        'course_option_id',
    ];

    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function option()
    {
        return $this->belongsTo(CourseOption::class, 'course_option_id');
    }

    public function assignments()
    {
        return $this->hasMany(
            LecturerCourseAssignment::class,
            'course_id'
        );
    }

    public function semester()
    {
        return $this->belongsTo(Semester::class);
    }

    // Connects Course -> Students through course_registrations pivot table
    public function students()
    {
        return $this->belongsToMany(
            Student::class,
            'course_registrations',
            'course_id',
            'student_id'
        );
    }

    // Total class sessions held for this course
    public function attendanceSessions()
    {
        return $this->hasMany(AttendanceSession::class);
    }

    // Attendance records through attendance sessions
    public function attendanceRecords()
    {
        return $this->hasManyThrough(AttendanceRecord::class, AttendanceSession::class);
    }

    public function sessions(): HasMany
    {
        return $this->hasMany(AttendanceSession::class);
    }

}
