<?php

namespace App\Livewire\Admin\Student\EditStudent;

use Livewire\Component;
use App\Models\AttendanceRecord;
use App\Models\Student;

class AttendanceHistory extends Component
{
    public $studentId;

    public function mount($studentId)
    {
        $this->studentId = $studentId;
    }

    public function render()
    {
        $student = Student::findOrFail($this->studentId);

        $records = AttendanceRecord::where('student_id', $this->studentId)
            ->latest('signed_in_at')
            ->get();

        return view('livewire.admin.student.edit-student.attendance-history', [
            'student' => $student,
            'records' => $records,
        ]);
    }
}
