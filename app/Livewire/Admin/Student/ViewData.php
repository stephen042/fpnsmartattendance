<?php

namespace App\Livewire\Admin\Student;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Student;

class ViewData extends Component
{
    use WithPagination;

    public $search = '';

    protected $paginationTheme = 'tailwind';

    public function updatingSearch()
    {
        $this->resetPage();
    }
    
    public function refreshData()
    {
        $this->resetPage();
    }

    public function render()
    {
        $students = Student::query()
            ->with([
                'level',
                'programme',
                'department',
                'courseOption'
            ])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('full_name', 'like', "%{$this->search}%")
                        ->orWhere('application_number', 'like', "%{$this->search}%")
                        ->orWhere('matric_number', 'like', "%{$this->search}%");
                });
            })
            ->orderByDesc('id')
            ->paginate(20);

        return view('livewire.admin.student.view-data', [
            'students' => $students
        ]);
    }
}
