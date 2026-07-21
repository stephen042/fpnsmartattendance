<?php

namespace App\Livewire\Admin\CourseRegistrationStudents;

use App\Jobs\ProcessBulkCourseRegistration;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;
<<<<<<< HEAD
use Livewire\WithPagination;
=======
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
use Maatwebsite\Excel\Facades\Excel;

class RegisterBulk extends Component
{
    use WithFileUploads;

    public $file;
    public array $rows = [];

<<<<<<< HEAD
    // Pagination properties for in-memory array
    public int $page = 1;
    public int $perPage = 10;

    public function updatedFile()
    {
        $this->rows = [];
        $this->page = 1;
=======
    public function updatedFile()
    {
        $this->rows = [];
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902

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

<<<<<<< HEAD
    // Computed property for paginating array rows
    public function getPaginatedRowsProperty()
    {
        $offset = ($this->page - 1) * $this->perPage;
        return array_slice($this->rows, $offset, $this->perPage);
    }

=======
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
    public function removeRow($index)
    {
        unset($this->rows[$index]);
        $this->rows = array_values($this->rows);
<<<<<<< HEAD

        // Adjust page number if current page becomes empty
        $maxPage = max(1, (int) ceil(count($this->rows) / $this->perPage));
        if ($this->page > $maxPage) {
            $this->page = $maxPage;
        }
=======
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
    }

    public function clearQueue()
    {
<<<<<<< HEAD
        $this->reset(['rows', 'file', 'page']);
=======
        $this->reset(['rows', 'file']);
>>>>>>> bdbae82bf891f35a56e581b67be80b9749ccf902
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