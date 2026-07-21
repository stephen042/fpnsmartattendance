<?php

namespace App\Livewire\Admin\ManageCourses;

use App\Models\Course;
use App\Models\CourseOption;
use App\Models\Level;
use Livewire\Component;

class ManageCourses extends Component
{
    public $course_name = '';

    public $course_code = '';

    public $course_type = 'theory';

    public $level_id = '';

    public $course_option_id = '';

    public $courseOptions = [];

    public $editCourseOptions = [];

    public $editId;

    public $edit_course_name = '';

    public $edit_course_code = '';

    public $edit_level_id = '';

    public $edit_course_option_id = '';

    public $edit_is_practical = false;

    public function mount()
    {
        $this->courseOptions = collect();
        $this->editCourseOptions = collect();
    }

    public function updatedLevelId($value)
    {
        $this->course_option_id = '';

        $this->courseOptions = CourseOption::where('level_id', $value)
            ->orderBy('name')
            ->get();
    }

    public function updatedEditLevelId($value)
    {
        $this->edit_course_option_id = '';

        $this->editCourseOptions = CourseOption::where('level_id', $value)
            ->orderBy('name')
            ->get();
    }

    public function updatedCourseType($value)
    {
        $this->course_type = $value ? 'practical' : 'theory';
    }

    public function createCourse()
    {
        $this->validate([
            'course_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:255',
            'level_id' => 'required|exists:levels,id',
            'course_option_id' => 'nullable|exists:course_options,id',
        ]);

        Course::create([
            'course_name' => $this->course_name,
            'course_code' => strtoupper($this->course_code),
            'course_type' => $this->course_type,
            'level_id' => $this->level_id,
            'course_option_id' => $this->course_option_id ?: null,
        ]);

        $this->reset([
            'course_name',
            'course_code',
            'level_id',
            'course_option_id',
        ]);

        $this->course_type = 'theory';

        session()->flash('success', 'Course created successfully.');
    }

    public function edit($id)
    {
        $course = Course::findOrFail($id);

        $this->editId = $course->id;
        $this->edit_course_name = $course->course_name;
        $this->edit_course_code = $course->course_code;
        $this->edit_level_id = $course->level_id;
        $this->edit_course_option_id = $course->course_option_id;
        $this->edit_is_practical = $course->course_type === 'practical';

        $this->editCourseOptions = CourseOption::where(
            'level_id',
            $course->level_id
        )->orderBy('name')->get();
    }

    public function updateCourse()
    {
        $this->validate([
            'edit_course_name' => 'required|string|max:255',
            'edit_course_code' => 'required|string|max:255',
            'edit_level_id' => 'required|exists:levels,id',
            'edit_course_option_id' => 'nullable|exists:course_options,id',
        ]);

        Course::findOrFail($this->editId)->update([
            'course_name' => $this->edit_course_name,
            'course_code' => strtoupper($this->edit_course_code),
            'course_type' => $this->edit_is_practical ? 'practical' : 'theory',
            'level_id' => $this->edit_level_id,
            'course_option_id' => $this->edit_course_option_id ?: null,
        ]);

        session()->flash('success', 'Course updated successfully.');
    }

    public function deleteCourse()
    {
        Course::findOrFail($this->editId)->delete();

        session()->flash('success', 'Course removed successfully.');
    }

    public function render()
    {
        return view('livewire.admin.manage-courses.manage-courses', [
            'levels' => Level::orderBy('name')->get(),

            'courses' => Course::with([
                'level',
                'option',
            ])
                ->latest()
                ->get(),
        ]);
    }
}
