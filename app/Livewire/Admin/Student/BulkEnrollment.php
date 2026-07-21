<?php

namespace App\Livewire\Admin\Student;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Student;
use App\Models\Department;
use App\Models\Level;
use App\Models\Programme;
use App\Models\CourseOption;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Jobs\ProcessBulkStudentEnrollment;


class BulkEnrollment extends Component
{
    use WithFileUploads;

    public $file;

    public $rows = [];

    public $perPage = 20;
    public $page = 1;

    public function getPaginatedRowsProperty()
    {
        return collect($this->rows)
            ->slice(($this->page - 1) * $this->perPage, $this->perPage)
            ->values();
    }

    public function updatedFile()
    {
        $this->rows = [];

        usleep(500000); // 0.5s UX buffer (optional)

        $data = Excel::toArray([], $this->file);

        $sheet = $data[0] ?? [];

        foreach ($sheet as $index => $row) {

            if ($index === 0) continue; // skip header

            $this->rows[] = [
                'application_number' => $row[0] ?? null,
                'matric_number' => $row[1] ?? null,
                'full_name' => $row[2] ?? null,
                'email' => $row[3] ?? null,
                'phone' => $row[4] ?? null,
                'gender' => $row[5] ?? null,
                'department' => $row[6] ?? null,
                'level' => $row[7] ?? null,
                'programme' => $row[8] ?? null,
                'course_option' => $row[9] ?? null,
            ];
        }
    }

    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
    }

    public function finalize()
    {
        if (empty($this->rows)) {

            session()->flash('error', 'No data to process.');

            return;
        }

        collect($this->rows)
            ->chunk(50)
            ->each(function ($chunk) {

                ProcessBulkStudentEnrollment::dispatch(
                    $chunk->toArray()
                );
            });

        session()->flash(
            'success',
            count($this->rows) . ' students queued for processing. Running in background...,wait a moments to see results. after a while, refresh the page to see the updated list of students.'
        );

        $this->reset(['rows', 'file']);
    }

    public function render()
    {
        return view('livewire.admin.student.bulk-enrollment');
    }
}
