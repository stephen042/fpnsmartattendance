<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CourseRegistration extends Model
{
    protected $fillable = [
        'student_id',
        'course_id',
        'academic_session_id',
        'semester_id',
        'level_id',
        'programme_id',
        'course_option_id',
        'registered_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Relationship to Academic Session
     */
    public function academicSession(): BelongsTo
    {
        return $this->belongsTo(AcademicSession::class, 'academic_session_id');
    }

    /**
     * Relationship to Semester
     */
    public function semester(): BelongsTo
    {
        return $this->belongsTo(Semester::class);
    }

    /**
     * Relationship to Course Option
     */
    public function courseOption(): BelongsTo
    {
        return $this->belongsTo(CourseOption::class, 'course_option_id');
    }

    /**
     * Relationship to Level
     */
    public function level(): BelongsTo
    {
        return $this->belongsTo(Level::class);
    }
}
