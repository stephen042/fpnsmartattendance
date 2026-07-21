<?php

namespace App\Livewire\Admin\CourseRegistrationStudents;

use App\Models\CourseRegistration;
use Livewire\Component;
use Livewire\WithPagination;

class RegisterData extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function refreshData()
    {
        $this->reset(['search']);
        $this->resetPage();
    }

    public function render()
    {
        $query = CourseRegistration::query()
            ->with([
                'student',
                'course',
                'academicSession',
                'semester',
                'courseOption',
                'level'
            ]);

        if (! empty(trim($this->search))) {
            $searchTerm = '%' . trim($this->search) . '%';

            $query->where(function ($q) use ($searchTerm) {
                // Search in Student details
                $q->whereHas('student', function ($sQuery) use ($searchTerm) {
                    $sQuery->where('full_name', 'like', $searchTerm)
                        ->orWhere('first_name', 'like', $searchTerm)
                        ->orWhere('last_name', 'like', $searchTerm)
                        ->orWhere('matric_number', 'like', $searchTerm)
                        ->orWhere('application_number', 'like', $searchTerm);
                })
                // Search in Course details
                ->orWhereHas('course', function ($cQuery) use ($searchTerm) {
                    $cQuery->where('course_code', 'like', $searchTerm)
                        ->orWhere('course_name', 'like', $searchTerm);
                });
            });
        }

        // Fetch records and group them by Student and Registration Scope
        $registrations = $query->latest()
            ->get()
            ->groupBy(function ($item) {
                return $item->student_id . '-' . $item->academic_session_id . '-' . $item->semester_id . '-' . $item->level_id . '-' . $item->course_option_id;
            });

        // Manual pagination for grouped Collection
        $currentPage = $this->getPage();
        $perPage = 10;
        $paginatedGroups = new \Illuminate\Pagination\LengthAwarePaginator(
            $registrations->slice(($currentPage - 1) * $perPage, $perPage),
            $registrations->count(),
            $perPage,
            $currentPage,
            ['path' => request()->url(), 'query' => request()->query()]
        );

        return view('livewire.admin.course-registration-students.register-data', [
            'registrationGroups' => $paginatedGroups,
        ]);
    }
}