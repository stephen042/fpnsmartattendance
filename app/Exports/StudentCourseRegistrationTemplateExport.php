<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentCourseRegistrationTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'Application Number',
            'Level',
            'Course Option',
            'Academic Session',
            'Semester',
            'Programme',
            'Course Code (SWD426, SWD427P)',
        ];
    }
}