<?php

namespace App\Livewire\Admin\Student\Editstudent;

use Livewire\Component;
use App\Models\Student;
use App\Models\Department;
use App\Models\Level;
use App\Models\Programme;
use App\Models\CourseOption;


class Edit extends Component
{
    public $studentId;

    public $application_number;
    public $matric_number;
    public $full_name;
    public $email;
    public $phone;
    public $gender;

    public $department_id;
    public $level_id;
    public $programme_id;
    public $course_option_id;

    public $confirmingDelete = false;

    public function mount($studentId)
    {
        $student = Student::findOrFail($studentId);

        $this->studentId = $student->id;

        $this->application_number = $student->application_number;
        $this->matric_number = $student->matric_number;
        $this->full_name = $student->full_name;
        $this->email = $student->email;
        $this->phone = $student->phone;
        $this->gender = $student->gender;

        $this->department_id = $student->department_id;
        $this->level_id = $student->level_id;
        $this->programme_id = $student->programme_id;
        $this->course_option_id = $student->course_option_id;
    }

    public function updateStudent()
    {
        $student = Student::findOrFail($this->studentId);

        $student->update([
            'application_number' => $this->application_number,
            'matric_number' => $this->matric_number,
            'full_name' => $this->full_name,
            'email' => $this->email,
            'phone' => $this->phone,
            'gender' => $this->gender,
            'department_id' => $this->department_id,
            'level_id' => $this->level_id,
            'programme_id' => $this->programme_id,
            'course_option_id' => $this->course_option_id,
        ]);

        session()->flash('success', 'Student updated successfully.');
    }

    public function confirmDelete()
    {
        $this->confirmingDelete = true;
    }

    public function deleteStudent()
    {
        $student = Student::findOrFail($this->studentId);

        $student->delete();

        session()->flash('success', 'Student deleted successfully.');

        return redirect()->route('student-enrollment');
    }

    public function render()
    {
        return view('livewire.admin.student.editstudent.edit', [
            'departments' => Department::all(),
            'levels' => Level::all(),
            'programmes' => Programme::all(),
            'courseOptions' => CourseOption::where('department_id', $this->department_id)->get(),
        ]);
    }
}
