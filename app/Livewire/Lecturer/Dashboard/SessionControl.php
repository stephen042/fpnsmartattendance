<?php

namespace App\Livewire\Lecturer\Dashboard;

use App\Models\AcademicSession;
use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\LecturerCourseAssignment;
use App\Models\Semester;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Livewire\Component;

class SessionControl extends Component
{
    public $selectedCourseId;

    /**
     * Holds the time string selected by the lecturer (e.g. "16:30")
     */
    public $sessionEnd;

    public $generatedCode;

    public function mount()
    {
        $lecturerId = Auth::id();

        // Check if lecturer has an active session right now
        $activeSession = AttendanceSession::where('lecturer_id', $lecturerId)
            ->where('is_active', true)
            ->first();

        if ($activeSession) {
            $this->selectedCourseId = $activeSession->course_id;
            $this->generatedCode = $activeSession->attendance_code;
            $this->sessionEnd = $activeSession->ended_at?->format('H:i');
        } else {
            // Default select the first assigned course
            $firstAssignment = LecturerCourseAssignment::where('lecturer_id', $lecturerId)->first();
            $this->selectedCourseId = $firstAssignment?->course_id;
            $this->generatedCode = strtoupper(Str::random(6));
        }
    }

    public function startSession()
    {
        $this->validate([
            'selectedCourseId' => 'required|exists:courses,id',
            'sessionEnd' => 'nullable|string', // Relax validation to accept AM/PM or HH:mm
        ]);

        $lecturerId = Auth::id();

        $endedAt = null;
        if ($this->sessionEnd) {
            try {
                // Carbon::parse() automatically handles "02:30 PM", "14:30", "2:30pm", etc.
                // It applies the time string onto today's date automatically.
                $endedAt = Carbon::parse($this->sessionEnd);

                // If the selected time today has already passed, return validation error
                if ($endedAt->isPast()) {
                    $this->addError('sessionEnd', 'The end time must be later than the current time.');

                    return;
                }
            } catch (\Exception $e) {
                $this->addError('sessionEnd', 'Please enter a valid time format (e.g., 2:30 PM or 14:30).');

                return;
            }
        }

        // Deactivate previous active sessions
        AttendanceSession::where('lecturer_id', $lecturerId)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'ended_at' => now(),
            ]);

        $activeSemester = Semester::where('is_active', true)->first();
        $activeAcademicSession = AcademicSession::where('is_active', true)->first();

        $expectedStudents = DB::table('course_registrations')
            ->where('course_id', $this->selectedCourseId)
            ->count();

        $this->generatedCode = strtoupper(Str::random(6));

        AttendanceSession::create([
            'course_id' => $this->selectedCourseId,
            'lecturer_id' => $lecturerId,
            'academic_session_id' => $activeAcademicSession?->id ?? 1,
            'semester_id' => $activeSemester?->id ?? 1,
            'attendance_code' => $this->generatedCode,
            'started_at' => now(),
            'ended_at' => $endedAt, // Carbon object passes seamlessly into Laravel's timestamp column
            'is_active' => true,
            'expected_students' => $expectedStudents,
        ]);

        session()->flash('message', 'Attendance session started successfully!');
    }

    public function endSession()
    {
        $lecturerId = Auth::id();

        AttendanceSession::where('lecturer_id', $lecturerId)
            ->where('is_active', true)
            ->update([
                'is_active' => false,
                'ended_at' => now(),
            ]);

        $this->reset(['selectedCourseId', 'sessionEnd']);
        $this->generatedCode = strtoupper(Str::random(6));

        session()->flash('message', 'Current attendance session has been ended.');
    }

    public function render()
    {
        $lecturerId = Auth::id();

        // Fetch assigned courses for dropdown
        $assignedCourses = LecturerCourseAssignment::where('lecturer_id', $lecturerId)
            ->with('course')
            ->get()
            ->pluck('course')
            ->filter();

        // Active session details
        $activeSession = AttendanceSession::where('lecturer_id', $lecturerId)
            ->where('is_active', true)
            ->with('course')
            ->first();

        // Live check-ins calculation
        $liveCheckInsCount = 0;
        $lastCheckIn = null;

        if ($activeSession) {
            $liveCheckInsCount = AttendanceRecord::where('attendance_session_id', $activeSession->id)
                ->where('status', 'present')
                ->count();

            $lastRecord = AttendanceRecord::where('attendance_session_id', $activeSession->id)
                ->latest('signed_in_at')
                ->first();

            $lastCheckIn = $lastRecord ? $lastRecord->signed_in_at->diffForHumans() : 'No check-ins yet';
        }

        return view('livewire.lecturer.dashboard.session-control', [
            'assignedCourses' => $assignedCourses,
            'activeSession' => $activeSession,
            'liveCheckInsCount' => $liveCheckInsCount,
            'lastCheckIn' => $lastCheckIn,
        ]);
    }
}
