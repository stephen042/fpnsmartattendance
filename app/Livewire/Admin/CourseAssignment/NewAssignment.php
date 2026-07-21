<?php

namespace App\Livewire\Admin\CourseAssignment;

use App\Models\Course;
use App\Models\LecturerCourseAssignment;
use App\Models\Semester;
use App\Models\User;
use Livewire\Component;

class NewAssignment extends Component
{
    public $search = '';

    public $semester_id = ''; // Filter property for semester

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
        // Query assignments filtered by lecturer name and optionally by course semester
        $assignments = User::query()
            ->where('role', 'lecturer')
            ->with([
                'assignedCourses' => function ($query) {
                    $query->when($this->semester_id, function ($q) {
                        $q->whereHas('course', function ($c) {
                            $c->where('semester_id', $this->semester_id);
                        });
                    });
                },
                'assignedCourses.course.level',
                'assignedCourses.course.semester',
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

            'semesters' => Semester::orderBy('name')->get(),

            'courses' => Course::with([
                'level',
                'semester',
                'option',
            ])
                ->when($this->semester_id, function ($query) {
                    $query->where('semester_id', $this->semester_id);
                })
                ->orderBy('course_code')
                ->get(),

            'assignments' => $assignments,
        ]);
    }
}