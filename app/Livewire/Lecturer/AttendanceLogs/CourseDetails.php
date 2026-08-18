<?php

namespace App\Livewire\Lecturer\AttendanceLogs;

use App\Models\AttendanceSession;
use App\Models\Course;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class CourseDetails extends Component
{
    use WithPagination;

    public Course $course;

    /**
     * Mount the route parameter (bound to Course model).
     */
    // Replace 'enrolledStudents' with 'students' (or whatever relationship name you defined)
    public function mount(Course $course): void
    {
        $this->course = $course->loadCount(['students', 'sessions']);
    }

    /**
     * Export all student attendance records for this entire course as CSV.
     */
    public function exportCourseRegistryCsv(): StreamedResponse
    {
        $sessions = AttendanceSession::where('course_id', $this->course->id)
            ->with(['records.student'])
            ->get();

        $courseCode = $this->course->course_code ?? 'course';
        $filename = "registry_{$courseCode}_all_sessions.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($sessions) {
            $file = fopen('php://output', 'w');

            // CSV Header
            fputcsv($file, ['Session ID', 'Session Date', 'Student ID', 'Matric No', 'Student Name', 'Signed In At', 'Status']);

            foreach ($sessions as $session) {
                $sessionDate = $session->started_at ? Carbon::parse($session->started_at)->format('Y-m-d H:i') : 'N/A';

                foreach ($session->records as $record) {
                    fputcsv($file, [
                        $session->id,
                        $sessionDate,
                        $record->student->application_no ?? $record->student_id ?? 'N/A',
                        $record->student->matric_no ?? 'N/A',
                        $record->student->name ?? 'N/A',
                        $record->signed_in_at ? Carbon::parse($record->signed_in_at)->format('Y-m-d H:i:s') : 'N/A',
                        $record->status ?? 'Present',
                    ]);
                }
            }

            fclose($file);
        }, 200, $headers);
    }

    /**
     * Export a single session's attendance as CSV.
     */
    public function exportSessionCsv(int $sessionId): StreamedResponse
    {
        $session = AttendanceSession::with(['records.student'])->findOrFail($sessionId);

        $courseCode = $this->course->course_code ?? 'course';
        $sessionDate = $session->started_at ? Carbon::parse($session->started_at)->format('Y-m-d') : 'session';
        $filename = "attendance_{$courseCode}_{$sessionDate}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($session) {
            $file = fopen('php://output', 'w');

            fputcsv($file, ['Student ID', 'Matric No', 'Student Name', 'Signed In At', 'Status', 'Verified Location']);

            foreach ($session->records as $record) {
                fputcsv($file, [
                    $record->student->application_no ?? $record->student_id ?? 'N/A',
                    $record->student->matric_no ?? 'N/A',
                    $record->student->name ?? 'N/A',
                    $record->signed_in_at ? Carbon::parse($record->signed_in_at)->format('Y-m-d H:i:s') : 'N/A',
                    $record->status ?? 'Present',
                    $record->verified_geolocation ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    public function render()
    {
        $sessions = AttendanceSession::where('course_id', $this->course->id)
            ->withCount('records')
            ->latest('started_at')
            ->paginate(10);

        // Overall average attendance across all sessions for this course
        $totalSessions = $this->course->sessions_count;
        $totalStudentsCount = $this->course->enrolled_students_count ?? 1;

        $overallAveragePct = 0;
        if ($totalSessions > 0) {
            $allSessionsRecordsCount = AttendanceSession::where('course_id', $this->course->id)
                ->withCount('records')
                ->get()
                ->sum('records_count');

            $maxPossibleCheckins = $totalSessions * $totalStudentsCount;
            $overallAveragePct = $maxPossibleCheckins > 0
                ? min(100, round(($allSessionsRecordsCount / $maxPossibleCheckins) * 100))
                : 0;
        }

        return view('livewire.lecturer.attendance-logs.course-details', [
            'sessions' => $sessions,
            'overallAveragePct' => $overallAveragePct,
        ]);
    }
}
