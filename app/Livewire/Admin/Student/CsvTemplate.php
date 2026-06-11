<?php

namespace App\Livewire\Admin\Student;

use App\Exports\StudentTemplateExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class CsvTemplate extends Component
{
    public function downloadTemplate()
    {
        return Excel::download(
            new StudentTemplateExport,
            'student_import_template.csv'
        );
    }
    public function render()
    {
        return view('livewire.admin.student.csv-template');
    }
}
