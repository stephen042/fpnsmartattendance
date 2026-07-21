<?php

namespace App\Livewire\Admin\CourseRegistrationStudents;

use App\Jobs\ProcessBulkCourseRegistration;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;

class RegisterBulk extends Component
{
    use WithFileUploads;

    public $file;
    public array $rows = [];

    public function updatedFile()
    {
        $this->rows = [];

        $data = Excel::toArray([], $this->file);
        $sheet = $data[0] ?? [];

        foreach ($sheet as $index => $row) {
            if ($index === 0) continue; // Skip CSV header
            if (empty(array_filter($row))) continue; // Skip empty rows

            $this->rows[] = [
                'application_number' => $row[0] ?? null,
                'level'              => $row[1] ?? null,
                'course_option'      => $row[2] ?? null,
                'academic_session'   => $row[3] ?? null,
                'semester'           => $row[4] ?? null,
                'programme'          => $row[5] ?? null,
                'course_codes'       => $row[6] ?? null, // Accepts e.g. "SWD427P, SWD427"
            ];
        }
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function clearQueue()
    {
        $this->reset(['rows', 'file']);
    }

    public function finalize()
    {
        if (empty($this->rows)) {
            session()->flash('error', 'Queue is empty.');
            return;
        }

        collect($this->rows)->chunk(50)->each(function ($chunk) {
            ProcessBulkCourseRegistration::dispatch($chunk->toArray(), Auth::id());
        });

        session()->flash('success', 'Bulk course registrations queued successfully!');
        $this->clearQueue();
    }

    public function render()
    {
        return view('livewire.admin.course-registration-students.register-bulk');
    }
}