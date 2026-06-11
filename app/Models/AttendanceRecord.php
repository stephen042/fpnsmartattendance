<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttendanceRecord extends Model
{
    protected $fillable = ['attendance_session_id', 'student_id', 'signed_in_at', 'status', 'latitude', 'longitude', 'verified_geolocation', 'device_hash'];
    
    public function session()
    {
        return $this->belongsTo(AttendanceSession::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
