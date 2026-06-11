<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = ['course_name', 'course_code', 'course_type', 'department_id', 'level_id', 'course_option_id'];
    
    public function registrations()
    {
        return $this->hasMany(CourseRegistration::class);
    }
}
