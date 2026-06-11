<?php

namespace App\Livewire\Admin\Dashboard;

use App\Models\Course;
use App\Models\Student;
use App\Models\User;
use App\Models\AttendanceSession;
use Livewire\Component;

class Overview extends Component
{

    public int $totalStudents = 0;
    public int $maleStudents = 0;
    public int $femaleStudents = 0;

    public int $totalLecturers = 0;
    public int $maleLecturers = 0;
    public int $femaleLecturers = 0;

    public int $totalCourses = 0;
    public int $ongoingCourses = 0;

    public function mount()
    {
        $this->loadStatistics();
    }

    public function loadStatistics(): void
    {
        $this->totalStudents = Student::count();

        $this->maleStudents = Student::where('gender', 'male')->count();

        $this->femaleStudents = Student::where('gender', 'female')->count();

        $this->totalLecturers = User::where('role', 'lecturer')->count();

        $this->maleLecturers = User::where('role', 'lecturer')
            ->whereHas('lecturerProfile', fn($query) => $query->where('gender', 'male'))
            ->count();

        $this->femaleLecturers = User::where('role', 'lecturer')
            ->whereHas('lecturerProfile', fn($query) => $query->where('gender', 'female'))
            ->count();

        $this->totalCourses = Course::count();

        $this->ongoingCourses = AttendanceSession::where('is_active', true)
            ->distinct('course_id')
            ->count('course_id');
    }

    public function render()
    {
        return view('livewire.admin.dashboard.overview');
    }
}
