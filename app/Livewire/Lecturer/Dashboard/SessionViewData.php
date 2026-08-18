<?php

namespace App\Livewire\Lecturer\Dashboard;

use App\Models\AttendanceSession;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SessionViewData extends Component
{
    use WithPagination;

    public string $search = '';

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function getSessionsProperty()
    {
        return AttendanceSession::with('course')
            ->withCount('records') // Efficiently loads $session->records_count
            ->where('lecturer_id', Auth::id())
            ->when($this->search, function ($query) {
                $query->whereHas('course', function ($q) {
                    $q->where('course_name', 'like', '%' . $this->search . '%')
                      ->orWhere('course_code', 'like', '%' . $this->search . '%');
                })
                ->orWhere('started_at', 'like', '%' . $this->search . '%');
            })
            ->orderBy('started_at', 'desc')
            ->paginate(10);
    }

    public function exportCsv(): StreamedResponse
    {
        $sessions = AttendanceSession::with(['course'])
            ->withCount('records')
            ->where('lecturer_id', Auth::id())
            ->orderBy('started_at', 'desc')
            ->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="session_history_' . now()->format('Y-m-d') . '.csv"',
        ];

        return response()->stream(function () use ($sessions) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Course Code', 'Course Name', 'Started At', 'Ended At', 'Status', 'Attendance']);

            foreach ($sessions as $session) {
                fputcsv($file, [
                    $session->course->course_code ?? 'N/A',
                    $session->course->course_name ?? 'N/A',
                    $session->started_at ? $session->started_at->format('Y-m-d H:i') : '',
                    $session->ended_at ? $session->ended_at->format('Y-m-d H:i') : 'N/A',
                    $session->is_active ? 'Active' : 'Closed',
                    ($session->records_count ?? 0) . ' / ' . ($session->expected_students ?? 0),
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    public function render()
    {
        return view('livewire.lecturer.dashboard.session-view-data', [
            'sessions' => $this->sessions,
        ]);
    }
}