<?php

namespace App\Jobs;

use App\Models\Student;
use App\Models\Department;
use App\Models\Level;
use App\Models\Programme;
use App\Models\CourseOption;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Log;

class ProcessBulkStudentEnrollment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    private function resolveCourseOption($row, $departmentId)
    {
        if (empty($row['course_option'])) {
            return null;
        }

        $input = strtoupper(trim($row['course_option']));

        return CourseOption::where('department_id', $departmentId)
            ->where(function ($q) use ($input) {

                $q->whereRaw('UPPER(code) = ?', [$input])
                    ->orWhereRaw('UPPER(name) LIKE ?', ['%' . $input . '%']);
            })
            ->value('id');
    }

    public function handle()
    {
        Log::info('JOB STARTED');

        // Department -> code
        $departments = Department::pluck('id', 'code');

        // Level -> name
        $levels = Level::pluck('id', 'name');

        // Programme -> name
        $programmes = Programme::pluck('id', 'name');

        foreach ($this->rows as $row) {

            $departmentCode = strtoupper(trim($row['department'] ?? ''));
            $levelName = trim($row['level'] ?? '');
            $programmeName = trim($row['programme'] ?? '');

            $departmentId = $departments[$departmentCode] ?? null;
            $levelId = $levels[$levelName] ?? null;
            $programmeId = $programmes[$programmeName] ?? null;

            if (!$departmentId || !$levelId || !$programmeId) {

                Log::warning('LOOKUP FAILED', [
                    'department' => $departmentCode,
                    'level' => $levelName,
                    'programme' => $programmeName,
                ]);

                continue;
            }

            $courseOptionId = $this->resolveCourseOption($row, $departmentId);

            try {

                Student::create([
                    'application_number' => trim($row['application_number']),
                    'matric_number' => trim($row['matric_number']),
                    'full_name' => trim($row['full_name']),
                    'email' => trim($row['email']),
                    'phone' => trim($row['phone']),
                    'gender' => strtolower(trim($row['gender'])),

                    'department_id' => $departmentId,
                    'level_id' => $levelId,
                    'programme_id' => $programmeId,
                    'course_option_id' => $courseOptionId,
                ]);

                Log::info('INSERTED', [
                    'application_number' => $row['application_number']
                ]);
            } catch (\Exception $e) {

                Log::error('INSERT FAILED', [
                    'application_number' => $row['application_number'],
                    'error' => $e->getMessage()
                ]);
            }
        }
    }
}
