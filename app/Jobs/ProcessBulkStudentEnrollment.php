<?php

namespace App\Jobs;

use App\Models\CourseOption;
use App\Models\Department;
use App\Models\Level;
use App\Models\Programme;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessBulkStudentEnrollment implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $rows;

    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    private function resolveCourseOption($row, $levelId)
    {
        if (empty($row['course_option'])) {
            return null;
        }

        $input = strtoupper(trim($row['course_option']));

        return CourseOption::where('level_id', $levelId)
            ->where(function ($q) use ($input) {
                $q->whereRaw('UPPER(code) = ?', [$input])
                  ->orWhereRaw('UPPER(name) LIKE ?', ['%' . $input . '%']);
            })
            ->value('id');
    }

    public function handle()
    {
        Log::info('JOB STARTED');

        // Normalize dictionary maps to uppercase keys for case-insensitive matching
        // 1. Department -> code
        $departments = Department::all()->keyBy(fn($item) => strtoupper(trim($item->code)));

        // 2. Level -> slug
        $levels = Level::all()->keyBy(fn($item) => strtoupper(trim($item->slug)));

        // 3. Programme -> name
        $programmes = Programme::all()->keyBy(fn($item) => strtoupper(trim($item->name)));

        foreach ($this->rows as $index => $row) {

            $departmentCode = strtoupper(trim($row['department'] ?? ''));
            $levelSlug      = strtoupper(trim($row['level'] ?? ''));
            $programmeName  = strtoupper(trim($row['programme'] ?? ''));

            // Match against normalized keys
            $departmentId = $departments->get($departmentCode)?->id;
            $levelId      = $levels->get($levelSlug)?->id;
            $programmeId  = $programmes->get($programmeName)?->id;

            if (!$departmentId || !$levelId || !$programmeId) {
                Log::warning("Row {$index}: LOOKUP FAILED", [
                    'dept' => $departmentCode,
                    'level' => $levelSlug,
                    'programme' => $programmeName,
                ]);

                continue;
            }

            // Resolve course option based on level_id
            $courseOptionId = $this->resolveCourseOption($row, $levelId);

            $appNo  = trim($row['application_number'] ?? '');
            $matric = !empty($row['matric_number']) ? trim($row['matric_number']) : null;

            try {
                // Check if student already exists by application_number or matric_number
                $existingStudent = Student::where(function ($q) use ($appNo, $matric) {
                    $q->where('application_number', $appNo);
                    if ($matric) {
                        $q->orWhere('matric_number', $matric);
                    }
                })->first();

                if ($existingStudent) {
                    // Check if already in this exact level
                    if ($existingStudent->level_id == $levelId) {
                        Log::info("Row {$index}: ALREADY ENROLLED IN LEVEL", [
                            'application_number' => $appNo,
                            'level_id'           => $levelId
                        ]);
                        continue;
                    }

                    // Student exists in a different level -> Update to latest Level details
                    $existingStudent->update([
                        'application_number' => $appNo,
                        'matric_number'      => $matric ?? $existingStudent->matric_number,
                        'full_name'          => trim($row['full_name']),
                        'email'              => !empty($row['email']) ? trim($row['email']) : $existingStudent->email,
                        'phone'              => !empty($row['phone']) ? trim($row['phone']) : $existingStudent->phone,
                        'gender'             => !empty($row['gender']) ? strtolower(trim($row['gender'])) : $existingStudent->gender,

                        'department_id'      => $departmentId,
                        'level_id'           => $levelId, // Updated to latest level
                        'programme_id'       => $programmeId,
                        'course_option_id'   => $courseOptionId,
                    ]);

                    Log::info("Row {$index}: LEVEL UPDATED", [
                        'application_number' => $appNo,
                        'new_level_id'       => $levelId
                    ]);

                } else {
                    // Create new student entry
                    Student::create([
                        'application_number' => $appNo,
                        'matric_number'      => $matric,
                        'full_name'          => trim($row['full_name']),
                        'email'              => !empty($row['email']) ? trim($row['email']) : null,
                        'phone'              => !empty($row['phone']) ? trim($row['phone']) : null,
                        'gender'             => !empty($row['gender']) ? strtolower(trim($row['gender'])) : null,

                        'department_id'      => $departmentId,
                        'level_id'           => $levelId,
                        'programme_id'       => $programmeId,
                        'course_option_id'   => $courseOptionId,
                    ]);

                    Log::info("Row {$index}: INSERTED", [
                        'application_number' => $appNo
                    ]);
                }

            } catch (\Exception $e) {
                Log::error("Row {$index}: PROCESSING FAILED", [
                    'application_number' => $appNo ?? 'N/A',
                    'error'              => $e->getMessage()
                ]);
            }
        }
    }
}