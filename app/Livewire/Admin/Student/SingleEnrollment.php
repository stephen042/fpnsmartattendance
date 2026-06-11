<?php

namespace App\Livewire\Admin\Student;

use Livewire\Component;
use App\Models\Level;
use App\Models\Student;
use App\Models\Department;
use App\Models\Programme;
use App\Models\CourseOption;
use Illuminate\Support\Facades\Hash;

class SingleEnrollment extends Component
{
    public $application_number;
    public $matric_number;
    public $full_name;
    public $email;
    public $phone;
    public $gender;

    public $department_id;
    public $course_option_id;

    public $level_id;
    public $programme_id;

    public $departments = [];
    public $courseOptions = [];
    public $levels = [];
    public $programmes = [];

    public function mount()
    {
        $this->departments = Department::orderBy('name')->get();

        $this->levels = Level::orderBy('name')->get();

        $this->programmes = Programme::orderBy('name')->get();
    }

    public function updatedDepartmentId($departmentId)
    {
        $this->course_option_id = null;

        $this->courseOptions = CourseOption::where('department_id', $departmentId)
            ->orderBy('name')
            ->get();
    }

    protected function rules()
    {
        return [
            'application_number' => 'required|unique:students,application_number',

            'matric_number' => 'nullable|unique:students,matric_number',

            'full_name' => 'required|string|max:255',

            'email' => 'nullable|email|unique:students,email',

            'phone' => 'nullable|string|max:20',

            'gender' => 'required|in:male,female',

            'department_id' => 'required|exists:departments,id',

            'course_option_id' => 'nullable|exists:course_options,id',

            'level_id' => 'required|exists:levels,id',

            'programme_id' => 'required|exists:programmes,id',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        Student::create([
            ...$validated,

            'password' => Hash::make(
                $this->application_number
            ),
        ]);

        $this->reset([
            'application_number',
            'matric_number',
            'full_name',
            'email',
            'phone',
            'gender',
            'department_id',
            'course_option_id',
            'level_id',
            'programme_id',
        ]);

        $this->courseOptions = [];

        session()->flash(
            'success',
            'Student enrolled successfully.'
        );
    }
    public function render()
    {
        return view('livewire.admin.student.single-enrollment');
    }
}
