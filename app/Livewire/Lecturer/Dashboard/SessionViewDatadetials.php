<?php

namespace App\Livewire\Lecturer\Dashboard;

use App\Models\AttendanceRecord;
use App\Models\AttendanceSession;
use App\Models\Semester;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SessionViewDatadetials extends Component
{
    use WithPagination;

    public AttendanceSession $session;

    public function mount(AttendanceSession $session): void
    {
        // Eager load initial course details
        $this->session = $session->load(['course']);
    }

    /**
     * Compute statistics for the top summary card.
     */
    public function getCourseStatsProperty(): array
    {
        $courseId = $this->session->course_id;

        // Get all sessions held for this course
        $allSessions = AttendanceSession::withCount('records')
            ->where('course_id', $courseId)
            ->get();

        $totalClasses = $allSessions->count();
        $totalExpected = $allSessions->sum('expected_students');
        $totalAttended = $allSessions->sum('records_count');

        $averageRate = $totalExpected > 0
            ? round(($totalAttended / $totalExpected) * 100)
            : 0;

        return [
            'total_students' => $this->session->expected_students ?? 0,
            'total_classes' => $totalClasses,
            'attendance_avg' => $averageRate,
        ];
    }

    /**
     * Fetch paginated student attendance records for the current session.
     */
    public function getAttendanceRecordsProperty()
    {
        return AttendanceRecord::with('student')
            ->where('attendance_session_id', $this->session->id)
            ->latest('signed_in_at')
            ->paginate(15);
    }

    /**
     * Toggle the suspension state of a student's record for this session.
     */
    public function toggleSuspension(int $recordId): void
    {
        $record = AttendanceRecord::where('attendance_session_id', $this->session->id)
            ->findOrFail($recordId);

        // Toggle status between 'suspended' and 'present' (or active state)
        $record->status = ($record->status === 'suspended') ? 'present' : 'suspended';
        $record->save();
    }

    /**
     * Export attendance details for a specific session to CSV.
     */
    public function exportSessionCsv(int $sessionId): StreamedResponse
    {
        $session = AttendanceSession::with(['course', 'records.student'])->findOrFail($sessionId);

        $filename = 'attendance_'.($session->course->course_code ?? 'course').'_'.$session->started_at->format('Y-m-d').'.csv';

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($session) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Student ID', 'Student Name', 'Signed In At', 'Status', 'Verified Location']);

            foreach ($session->records as $record) {
                fputcsv($file, [
                    $record->student->student_number ?? $record->student_id ?? 'N/A',
                    $record->student->name ?? 'N/A',
                    $record->signed_in_at ? \Carbon\Carbon::parse($record->signed_in_at)->format('Y-m-d H:i:s') : 'N/A',
                    $record->status ?? 'Present',
                    $record->verified_geolocation ? 'Yes' : 'No',
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    public function render()
    {
        $currentSemester = Semester::where('is_active', true)->first()?->name
            ?? $assignments->first()?->course?->semester?->name
            ?? 'Current Semester';

        return view('livewire.lecturer.dashboard.session-view-datadetials', [
            'stats' => $this->courseStats,
            'records' => $this->attendanceRecords,
            'currentSemester' => $currentSemester
        ]);
    }
}