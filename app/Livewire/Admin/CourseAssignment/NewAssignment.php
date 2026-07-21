<?php

namespace App\Livewire\Admin\CourseAssignment;

use App\Models\Course;
use App\Models\LecturerCourseAssignment;
use App\Models\User;
use Livewire\Component;

class NewAssignment extends Component
{
    public $search = '';

    public $lecturer_id = '';

    public $selectedCourses = [];

    public function assignCourses()
    {
        $this->validate([
            'lecturer_id' => 'required|exists:users,id',
            'selectedCourses' => 'required|array|min:1',
        ]);

        foreach ($this->selectedCourses as $courseId) {

            LecturerCourseAssignment::firstOrCreate([
                'lecturer_id' => $this->lecturer_id,
                'course_id' => $courseId,
            ]);
        }

        $this->reset([
            'lecturer_id',
            'selectedCourses',
        ]);

        session()->flash(
            'success',
            'Courses assigned successfully.'
        );
    }

    public function assignedCourses()
    {
        return $this->hasMany(
            LecturerCourseAssignment::class,
            'lecturer_id'
        );
    }

    public function removeAssignment($id)
    {
        LecturerCourseAssignment::findOrFail($id)->delete();

        session()->flash(
            'success',
            'Course assignment removed successfully.'
        );
    }

    public function render()
    {
        $assignments = User::query()
            ->where('role', 'lecturer')
            ->with([
                'assignedCourses.course.level',
                'assignedCourses.course.option',
            ])
            ->when($this->search, function ($query) {

                $query->where('name', 'like', '%'.$this->search.'%');

            })
            ->orderBy('name')
            ->get();

        return view('livewire.admin.course-assignment.new-assignment', [

            'lecturers' => User::where('role', 'lecturer')
                ->orderBy('name')
                ->get(),

            'courses' => Course::with([
                'level',
                'option',
            ])
                ->orderBy('course_code')
                ->get(),

            'assignments' => $assignments,
        ]);
    }
}
