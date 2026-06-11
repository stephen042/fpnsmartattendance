<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\AttendanceRecord;
use App\Models\CourseOption;
use App\Models\Level;
use App\Models\Programme;
use App\Models\Student;
use Carbon\Carbon;
use Livewire\Component;

class Chart extends Component
{

    public $levels = [];
    public $programmes = [];
    public $courseOptions = [];

    public $level_id = '';
    public $programme_id = '';
    public $course_option_id = '';

    public int $totalStudents = 0;
    public int $presentStudents = 0;
    public int $absentStudents = 0;
    public float $attendancePercentage = 0;

    public function mount()
    {
        $this->levels = Level::orderBy('name')->get();
        $this->programmes = Programme::orderBy('name')->get();
        $this->courseOptions = CourseOption::orderBy('name')->get();

        $this->loadStatistics();
    }

    public function applyFilters()
    {
        $this->loadStatistics();
    }

    public function loadStatistics()
    {
        $studentsQuery = Student::query();

        if ($this->level_id) {
            $studentsQuery->where('level_id', $this->level_id);
        }

        if ($this->programme_id) {
            $studentsQuery->where('programme_id', $this->programme_id);
        }

        if ($this->course_option_id) {
            $studentsQuery->where('course_option_id', $this->course_option_id);
        }

        $studentIds = $studentsQuery->pluck('id');

        $this->totalStudents = $studentIds->count();

        $this->presentStudents = AttendanceRecord::whereDate(
            'signed_in_at',
            Carbon::today()
        )
            ->whereIn('student_id', $studentIds)
            ->distinct('student_id')
            ->count('student_id');

        $this->absentStudents = max(
            0,
            $this->totalStudents - $this->presentStudents
        );

        $this->attendancePercentage = $this->totalStudents > 0
            ? round(($this->presentStudents / $this->totalStudents) * 100)
            : 0;
    }
    
    public function render()
    {
        return view('livewire.admin.dashboard.chart');
    }
}
