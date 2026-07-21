<?php

namespace App\Livewire\Admin\CourseRegistrationStudents;

use App\Models\AcademicSession;
use App\Models\Course;
use App\Models\CourseOption;
use App\Models\CourseRegistration;
use App\Models\Level;
use App\Models\Programme;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class RegisterSingle extends Component
{
    // Form fields
    public $search_identifier = '';
<<<<<<< HEAD

    public $student_id = null;

    public $student_name = '';

    public $level_id = '';

    public $course_option_id = '';

    public $academic_session_id = '';

    public $semester_id = '';

    public $programme_id = '';

=======
    public $student_id = null;
    public $student_name = '';

    public $level_id = '';
    public $course_option_id = '';
    public $academic_session_id = '';
    public $semester_id = '';
    public $programme_id = '';
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
    public $course_id = '';

    // Real-time lookup whenever the matric/app-no changes
    public function updatedSearchIdentifier($value)
    {
        $value = trim($value);

        if (empty($value)) {
            $this->resetStudentInfo();
<<<<<<< HEAD

=======
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
            return;
        }

        $student = Student::where('matric_number', $value)
            ->orWhere('application_number', $value)
            ->first();

        if ($student) {
            $this->student_id = $student->id;
            $this->student_name = $student->full_name;
<<<<<<< HEAD

=======
            
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
            // Auto-prefill existing student scopes if available
            $this->level_id = $student->level_id ?? '';
            $this->programme_id = $student->programme_id ?? '';
            $this->course_option_id = $student->course_option_id ?? '';
        } else {
            $this->resetStudentInfo();
        }
    }

    // Reset option and course dependent fields when level changes
    public function updatedLevelId()
    {
        $this->course_option_id = '';
        $this->course_id = '';
    }

    // Reset course choice when option changes
    public function updatedCourseOptionId()
    {
        $this->course_id = '';
    }

<<<<<<< HEAD
    // Reset course choice when semester changes
    public function updatedSemesterId()
    {
        $this->course_id = '';
    }

=======
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
    private function resetStudentInfo()
    {
        $this->student_id = null;
        $this->student_name = '';
    }

    public function saveRegistration()
    {
        $this->validate([
<<<<<<< HEAD
            'student_id' => 'required|exists:students,id',
            'level_id' => 'required|exists:levels,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'semester_id' => 'required|exists:semesters,id',
            'programme_id' => 'required|exists:programmes,id',
            'course_id' => 'required|exists:courses,id',
            'course_option_id' => 'nullable|exists:course_options,id',
        ], [
            'student_id.required' => 'Please enter a valid Student APP-NO or Matric Number.',
            'course_id.required' => 'Please select a course module from the list.',
=======
            'student_id'          => 'required|exists:students,id',
            'level_id'            => 'required|exists:levels,id',
            'academic_session_id' => 'required|exists:academic_sessions,id',
            'semester_id'         => 'required|exists:semesters,id',
            'programme_id'        => 'required|exists:programmes,id',
            'course_id'           => 'required|exists:courses,id',
            'course_option_id'    => 'nullable|exists:course_options,id',
        ], [
            'student_id.required' => 'Please enter a valid Student APP-NO or Matric Number.',
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
        ]);

        // Check if registration already exists
        $exists = CourseRegistration::where([
<<<<<<< HEAD
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'academic_session_id' => $this->academic_session_id,
            'semester_id' => $this->semester_id,
=======
            'student_id'          => $this->student_id,
            'course_id'           => $this->course_id,
            'academic_session_id' => $this->academic_session_id,
            'semester_id'         => $this->semester_id,
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
        ])->exists();

        if ($exists) {
            session()->flash('error', 'Student is already registered for this course in the selected session/semester.');
<<<<<<< HEAD

=======
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
            return;
        }

        CourseRegistration::create([
<<<<<<< HEAD
            'student_id' => $this->student_id,
            'course_id' => $this->course_id,
            'academic_session_id' => $this->academic_session_id,
            'semester_id' => $this->semester_id,
            'level_id' => $this->level_id,
            'course_option_id' => $this->course_option_id ?: null,
            'programme_id' => $this->programme_id,
            'registered_by' => Auth::id(),
=======
            'student_id'          => $this->student_id,
            'course_id'           => $this->course_id,
            'academic_session_id' => $this->academic_session_id,
            'semester_id'         => $this->semester_id,
            'level_id'            => $this->level_id,
            'course_option_id'    => $this->course_option_id ?: null,
            'programme_id'        => $this->programme_id,
            'registered_by'       => Auth::id(),
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
        ]);

        session()->flash('success', 'Course registration saved successfully.');

        // Reset course choice
        $this->reset(['course_id']);
    }

    public function render()
    {
        // 1. Fetch available options for the selected Level
        $courseOptions = collect();
        if ($this->level_id) {
            $courseOptions = CourseOption::where('level_id', $this->level_id)->get();
        }

<<<<<<< HEAD
        // 2. Fetch available courses filtered by Level, Semester, and Course Option
        $courses = collect();
        if ($this->level_id && $this->semester_id) {
            $courses = Course::where('level_id', $this->level_id)
                ->where('semester_id', $this->semester_id)
=======
        // 2. Fetch available courses filtered by Level and Option
        $courses = collect();
        if ($this->level_id) {
            $courses = Course::where('level_id', $this->level_id)
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
                ->when($this->course_option_id, function ($query) {
                    $query->where('course_option_id', $this->course_option_id);
                }, function ($query) {
                    // If no option chosen/available, load courses with no option restriction
                    $query->whereNull('course_option_id');
                })
                ->orderBy('course_code')
                ->get();
        }

        return view('livewire.admin.course-registration-students.register-single', [
<<<<<<< HEAD
            'levels' => Level::all(),
            'academicSessions' => AcademicSession::all(),
            'semesters' => Semester::all(),
            'programmes' => Programme::all(),
            'courseOptions' => $courseOptions,
            'courses' => $courses,
=======
            'levels'           => Level::all(),
            'academicSessions' => AcademicSession::all(),
            'semesters'        => Semester::all(),
            'programmes'       => Programme::all(),
            'courseOptions'    => $courseOptions,
            'courses'          => $courses,
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
        ]);
    }
}
