<?php

namespace App\Livewire\Admin\CourseRegistrationStudents;

use App\Exports\StudentCourseRegistrationTemplateExport;
use Livewire\Component;
use Maatwebsite\Excel\Facades\Excel;

class CsvTemplate extends Component
{
    public function downloadTemplate()
    {
        return Excel::download(
            new StudentCourseRegistrationTemplateExport,
            'student_course_registration_template.csv'
        );
    }

    public function render()
    {
        return view('livewire.admin.course-registration-students.csv-template');
    }
}
