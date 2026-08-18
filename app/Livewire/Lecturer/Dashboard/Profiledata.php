<?php

namespace App\Livewire\Lecturer\Dashboard;

use App\Models\LecturerCourseAssignment;
use App\Models\Semester;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Profiledata extends Component
{
    public function render()
    {
        $lecturerId = Auth::id();

        // Eager load registered students count & class sessions count
        $assignments = LecturerCourseAssignment::where('lecturer_id', $lecturerId)
            ->with([
                'course.semester',
                'course' => function ($query) {
                    $query->withCount([
                        'students',
                        'attendanceSessions as classes_count',
                    ]);
                },
            ])
            ->get();

        // Grab current active semester or fall back gracefully
        $currentSemester = Semester::where('is_active', true)->first()?->name
            ?? $assignments->first()?->course?->semester?->name
            ?? 'Current Semester';

        $courses = $assignments->map(function ($assignment) {
            $course = $assignment->course;

            if (! $course) {
                return null;
            }

            $studentsCount = $course->students_count ?? 0;
            $classesCount = $course->classes_count ?? 0;

            // Attendance Percentage Calculation
            $attendanceAvg = 0;
            if ($studentsCount > 0 && $classesCount > 0) {
                $totalPossibleAttendances = $studentsCount * $classesCount;

                // Count actual 'present' records linked to this course's sessions
                $actualPresents = $course->attendanceRecords()
                    ->where('status', 'present')
                    ->count();

                $attendanceAvg = round(($actualPresents / $totalPossibleAttendances) * 100);
            }

            return [
                'id' => $course->id,
                'name' => $course->course_name,
                'code' => $course->course_code,
                'type' => ucfirst($course->course_type ?? 'theory'),
                'students_count' => $studentsCount,
                'classes_count' => $classesCount,
                'attendance_avg' => min($attendanceAvg, 100), // Cap at 100% max
            ];
        })->filter();

        return view('livewire.lecturer.dashboard.profiledata', [
            'courses' => $courses,
            'assignedCount' => $courses->count(),
            'currentSemester' => $currentSemester,
        ]);
    }
}
