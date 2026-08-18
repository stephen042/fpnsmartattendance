<?php

namespace App\Livewire\Lecturer\AttendanceLogs;

use App\Models\AttendanceSession;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SessionHistory extends Component
{
    use WithPagination;

    public string $search = '';

    // Reset pagination when searching
    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    /**
     * Download CSV report for a given session.
     */
    public function exportSessionCsv(int $sessionId): StreamedResponse
    {
        $session = AttendanceSession::with(['course', 'records.student'])->findOrFail($sessionId);

        $courseCode = $session->course->course_code ?? 'course';
        $sessionDate = $session->started_at ? $session->started_at->format('Y-m-d') : 'session';
        $filename = "attendance_{$courseCode}_{$sessionDate}.csv";

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ];

        return response()->stream(function () use ($session) {
            $file = fopen('php://output', 'w');

            // Header Row
            fputcsv($file, ['Student ID', 'Matric No', 'Student Name', 'Signed In At', 'Status', 'Verified Location']);

            // Data Rows
            foreach ($session->records as $record) {
                fputcsv($file, [
                    $record->student->application_no ?? $record->student_id ?? 'N/A',
                    $record->student->matric_no ?? 'N/A',
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
        $searchTerm = '%'.$this->search.'%';

        $sessions = AttendanceSession::with(['course'])
            ->withCount('records')
            ->when($this->search, function ($query) use ($searchTerm) {
                $query->whereHas('course', function ($q) use ($searchTerm) {
                    $q->where('course_name', 'like', $searchTerm)
                        ->orWhere('course_code', 'like', $searchTerm);
                })
                    ->orWhereDate('started_at', 'like', $searchTerm);
            })
            ->latest('started_at')
            ->paginate(10);

        return view('livewire.lecturer.attendance-logs.session-history', [
            'sessions' => $sessions,
        ]);
    }
}
