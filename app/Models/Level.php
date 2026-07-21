<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Level extends Model
{
    protected $fillable = ['name', 'slug'];

    public function courseOptions()
    {
        return $this->hasMany(CourseOption::class);
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
