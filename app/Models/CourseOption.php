<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseOption extends Model
{
    protected $fillable = ['level_id', 'name', 'code'];

    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function courses()
    {
        return $this->hasMany(
            Course::class,
            'course_option_id'
        );
    }
}
