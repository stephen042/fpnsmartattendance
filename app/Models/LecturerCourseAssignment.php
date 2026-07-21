<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LecturerCourseAssignment extends Model
{
    protected $fillable = [
        'lecturer_id',
        'course_id',
    ];

    public function lecturer()
    {
        return $this->belongsTo(
            User::class,
            'lecturer_id'
        );
    }

    public function course()
    {
        return $this->belongsTo(
            Course::class,
            'course_id'
        );
    }
}
