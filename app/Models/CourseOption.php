<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseOption extends Model
{
    protected $fillable = ['department_id', 'name', 'code'];
    public function department()
    {
        return $this->belongsTo(Department::class);
    }
}
