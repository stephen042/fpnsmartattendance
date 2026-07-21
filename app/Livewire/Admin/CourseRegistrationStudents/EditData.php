<?php

namespace App\Livewire\Admin\CourseRegistrationStudents;

use App\Models\Course;
use App\Models\CourseRegistration;
use Livewire\Component;

class EditData extends Component
{
    public $registrationId;

    public CourseRegistration $primaryRegistration;

    // Group context
    public $student;

    public $academicSessionId;

    public $semesterId;

    public $levelId;

    public $courseOptionId;

    public $programmeId; // Added programme_id property

    // Course state
    public array $registeredCourseIds = [];

    public $selectedNewCourseId = '';

    public function mount($id)
    {
        $this->registrationId = $id;

        // Fetch primary registration record
        $this->primaryRegistration = CourseRegistration::with([
            'student',
            'academicSession',
            'semester',
            'courseOption',
            'level',
        ])->where('id', $id)->firstOrFail();

        // Extract context scope details
        $this->student = $this->primaryRegistration->student;
        $this->academicSessionId = $this->primaryRegistration->academic_session_id;
        $this->semesterId = $this->primaryRegistration->semester_id;
        $this->levelId = $this->primaryRegistration->level_id;
        $this->courseOptionId = $this->primaryRegistration->course_option_id;

        // Fetch programme_id from primary registration or fallback to student's programme_id
        $this->programmeId = $this->primaryRegistration->programme_id ?? $this->student->programme_id;

        // Load active courses for this student within this scope
        $this->loadGroupedCourses();
    }

    public function loadGroupedCourses()
    {
        $this->registeredCourseIds = CourseRegistration::query()
            ->where('student_id', $this->student->id)
            ->where('academic_session_id', $this->academicSessionId)
            ->where('semester_id', $this->semesterId)
            ->where('level_id', $this->levelId)
            ->where('course_option_id', $this->courseOptionId)
            ->pluck('course_id')
            ->toArray();
    }

    // Add a course module to this student's registration scope
    public function addCourse()
    {
        if (empty($this->selectedNewCourseId)) {
            return;
        }

        CourseRegistration::firstOrCreate([
            'student_id' => $this->student->id,
            'course_id' => $this->selectedNewCourseId,
            'academic_session_id' => $this->academicSessionId,
            'semester_id' => $this->semesterId,
            'level_id' => $this->levelId,
            'course_option_id' => $this->courseOptionId,
        ], [
            'programme_id' => $this->programmeId, // Passed programme_id here
            'registered_by' => auth()->id() ?? 1,
        ]);

        $this->selectedNewCourseId = '';
        $this->loadGroupedCourses();

        session()->flash('message', 'Course added successfully.');
    }

    // Remove a single course registration
    public function removeCourse($courseId)
    {
        CourseRegistration::where('student_id', $this->student->id)
            ->where('course_id', $courseId)
            ->where('academic_session_id', $this->academicSessionId)
            ->where('semester_id', $this->semesterId)
            ->where('level_id', $this->levelId)
            ->where('course_option_id', $this->courseOptionId)
            ->delete();

        $this->loadGroupedCourses();

        session()->flash('message', 'Course removed successfully.');
    }

    // Bulk Unenroll Student from all courses in this scope
    public function unenrollAll()
    {
        CourseRegistration::where('student_id', $this->student->id)
            ->where('academic_session_id', $this->academicSessionId)
            ->where('semester_id', $this->semesterId)
            ->where('level_id', $this->levelId)
            ->where('course_option_id', $this->courseOptionId)
            ->delete();

        return redirect()->route('course-registration-students')
            ->with('message', 'Student successfully unenrolled from all courses in this scope.');
    }

    public function render()
    {
        $activeCourses = Course::whereIn('id', $this->registeredCourseIds)->get();

        $availableCourses = Course::where('level_id', $this->levelId)
<<<<<<< HEAD
            ->where('semester_id', $this->semesterId) // Filter by active semester
=======
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
            ->when(! empty($this->courseOptionId), function ($q) {
                $q->where('course_option_id', $this->courseOptionId);
            })
            ->whereNotIn('id', $this->registeredCourseIds)
            ->orderBy('course_code')
            ->get();

        return view('livewire.admin.course-registration-students.edit-data', [
            'activeCourses' => $activeCourses,
            'availableCourses' => $availableCourses,
        ]);
    }
}
