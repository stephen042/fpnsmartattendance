<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $fillable = ['name', 'code'];
    
    public function options()
    {
        return $this->hasMany(CourseOption::class);
    }
    public function students()
    {
        return $this->hasMany(Student::class);
    }
}
