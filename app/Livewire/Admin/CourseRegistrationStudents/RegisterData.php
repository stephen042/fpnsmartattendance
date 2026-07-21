<?php

namespace App\Livewire\Admin\CourseRegistrationStudents;

use App\Models\AcademicSession;
use App\Models\CourseOption;
use App\Models\CourseRegistration;
use App\Models\Level;
use App\Models\Semester;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class RegisterData extends Component
{
    use WithPagination;

    // Search and Filters
    public string $search = '';

    public string $filter_session_id = '';

    public string $filter_level_id = '';

    public string $filter_semester_id = '';

    public string $filter_course_option_id = '';

    // Reset pagination on filter update
    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedFilterSessionId()
    {
        $this->resetPage();
    }

    public function updatedFilterLevelId()
    {
        $this->filter_course_option_id = '';
        $this->resetPage();
    }

    public function updatedFilterSemesterId()
    {
        $this->resetPage();
    }

    public function updatedFilterCourseOptionId()
    {
        $this->resetPage();
    }

    public function refreshData()
    {
        $this->reset([
            'search',
            'filter_session_id',
            'filter_level_id',
            'filter_semester_id',
            'filter_course_option_id',
        ]);
        $this->resetPage();
    }

    public function render()
    {
        // 1. Query grouped registration keys directly from the database for smooth Livewire pagination
        $groupsQuery = CourseRegistration::query()
            ->select(
                'student_id',
                'academic_session_id',
                'semester_id',
                'level_id',
                'course_option_id',
                DB::raw('MAX(created_at) as latest_created_at')
            );

        // Apply Dropdown Filters to database query
        if (! empty($this->filter_session_id)) {
            $groupsQuery->where('academic_session_id', $this->filter_session_id);
        }

        if (! empty($this->filter_level_id)) {
            $groupsQuery->where('level_id', $this->filter_level_id);
        }

        if (! empty($this->filter_semester_id)) {
            $groupsQuery->where('semester_id', $this->filter_semester_id);
        }

        if ($this->filter_course_option_id !== '') {
            if ($this->filter_course_option_id === 'none') {
                $groupsQuery->whereNull('course_option_id');
            } else {
                $groupsQuery->where('course_option_id', $this->filter_course_option_id);
            }
        }

        // Apply Search Filter across Student or Course relationships
        if (! empty(trim($this->search))) {
            $searchTerm = '%'.trim($this->search).'%';
            $groupsQuery->where(function ($q) use ($searchTerm) {
                $q->whereHas('student', function ($sQuery) use ($searchTerm) {
                    $sQuery->where('full_name', 'like', $searchTerm)
                        ->orWhere('first_name', 'like', $searchTerm)
                        ->orWhere('last_name', 'like', $searchTerm)
                        ->orWhere('matric_number', 'like', $searchTerm)
                        ->orWhere('application_number', 'like', $searchTerm);
                })
                    ->orWhereHas('course', function ($cQuery) use ($searchTerm) {
                        $cQuery->where('course_code', 'like', $searchTerm)
                            ->orWhere('course_name', 'like', $searchTerm);
                    });
            });
        }

        // Group, Order and Paginate groups
        $paginatedGroupKeys = $groupsQuery
            ->groupBy('student_id', 'academic_session_id', 'semester_id', 'level_id', 'course_option_id')
            ->orderBy('latest_created_at', 'desc')
            ->paginate(15);

        // 2. Fetch full registration records along with relationships for current paginated page
        $registrationGroups = collect();

        if ($paginatedGroupKeys->count() > 0) {
            $fullRegistrationsQuery = CourseRegistration::with([
                'student',
                'course',
                'academicSession',
                'semester',
                'courseOption',
                'level',
            ]);

            // Filter for only records matching the current page's group combinations
            $fullRegistrationsQuery->where(function ($q) use ($paginatedGroupKeys) {
                foreach ($paginatedGroupKeys as $group) {
                    $q->orWhere(function ($sub) use ($group) {
                        $sub->where('student_id', $group->student_id)
                            ->where('academic_session_id', $group->academic_session_id)
                            ->where('semester_id', $group->semester_id)
                            ->where('level_id', $group->level_id);

                        if (is_null($group->course_option_id)) {
                            $sub->whereNull('course_option_id');
                        } else {
                            $sub->where('course_option_id', $group->course_option_id);
                        }
                    });
                }
            });

            $allPageRecords = $fullRegistrationsQuery->get();

            // Structure records into key-value groups
            $registrationGroups = $allPageRecords->groupBy(function ($item) {
                return $item->student_id.'-'.$item->academic_session_id.'-'.$item->semester_id.'-'.$item->level_id.'-'.($item->course_option_id ?? 'none');
            });
        }

        // Fetch course options dynamically based on chosen level filter
        $courseOptions = $this->filter_level_id
            ? CourseOption::where('level_id', $this->filter_level_id)->get()
            : CourseOption::all();

        return view('livewire.admin.course-registration-students.register-data', [
            'paginatedGroupKeys' => $paginatedGroupKeys,
            'registrationGroups' => $registrationGroups,
            'academicSessions' => AcademicSession::all(),
            'levels' => Level::all(),
            'semesters' => Semester::all(),
            'courseOptions' => $courseOptions,
        ]);
    }
}
