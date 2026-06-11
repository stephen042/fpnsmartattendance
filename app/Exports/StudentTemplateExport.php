<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\WithHeadings;

class StudentTemplateExport implements WithHeadings
{
    public function headings(): array
    {
        return [
            'Application Number',
            'Matric Number',
            'Full Name',
            'Email',
            'Phone',
            'Gender',
            'Department (eg: CS)',
            'Course Option (eg: SWD)',
            'Level (eg: HND1)',
            'Programme (eg: EVENING, MORNING, WEEKEND)',
        ];
    }
}