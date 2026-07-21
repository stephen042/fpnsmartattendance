<?php

namespace App\Jobs;

use App\Models\AcademicSession;
use App\Models\Course;
use App\Models\CourseRegistration;
use App\Models\Level;
use App\Models\Programme;
use App\Models\Semester;
use App\Models\Student;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class ProcessBulkCourseRegistration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $rows;

    public ?int $registeredBy;

    public function __construct(array $rows, ?int $registeredBy = null)
    {
        $this->rows = $rows;
        $this->registeredBy = $registeredBy;
    }

    public function handle(): void
    {
        Log::info('BULK COURSE REGISTRATION STARTED');

        // Pre-load reference maps for maximum performance
        $levels = Level::all()->keyBy(fn ($item) => strtoupper(trim($item->name)));
        $sessions = AcademicSession::all()->keyBy(fn ($item) => strtoupper(trim($item->name)));
        $semesters = Semester::all()->keyBy(fn ($item) => strtoupper(trim($item->name)));
        $programmes = Programme::all()->keyBy(fn ($item) => strtoupper(trim($item->name)));

        // Map courses by course_code for instant lookup
        $courses = Course::all()->keyBy(fn ($item) => strtoupper(trim($item->course_code)));

        foreach ($this->rows as $rowIndex => $row) {
            $appNo = trim($row['application_number'] ?? '');
            $levelName = strtoupper(trim($row['level'] ?? ''));
            $sessionName = strtoupper(trim($row['academic_session'] ?? ''));
            $semName = strtoupper(trim($row['semester'] ?? ''));
            $progName = strtoupper(trim($row['programme'] ?? ''));
            $coursesRaw = $row['course_codes'] ?? ''; // e.g. "SWD427P, SWD427"

            // 1. Fetch Student by Application or Matric Number
            $student = Student::where('application_number', $appNo)
                ->orWhere('matric_number', $appNo)
                ->first();

            if (! $student) {
                Log::warning("Row {$rowIndex}: Student not found with Application/Matric No: {$appNo}");

                continue;
            }

            // 2. Resolve Scope Foreign Keys
            $levelId = $levels->get($levelName)?->id ?? $student->level_id;
            $sessionId = $sessions->get($sessionName)?->id;
            $semesterId = $semesters->get($semName)?->id;
            $programmeId = $programmes->get($progName)?->id ?? $student->programme_id;

            if (! $sessionId || ! $semesterId || ! $levelId || ! $programmeId) {
                Log::warning("Row {$rowIndex}: Missing required scope context for student ID {$student->id}");

                continue;
            }

            // 3. Parse Comma-Separated Course Codes
            $courseCodesArray = array_filter(array_map('trim', explode(',', $coursesRaw)));

            if (empty($courseCodesArray)) {
                Log::warning("Row {$rowIndex}: No course codes provided.");

                continue;
            }

            // 4. Register Each Course
            foreach ($courseCodesArray as $code) {
                $cleanCode = strtoupper($code);
                $course = $courses->get($cleanCode);

                if (! $course) {
                    Log::warning("Row {$rowIndex}: Course Code '{$cleanCode}' not found in database.");

                    continue;
                }

                // Append course if not already registered (avoids duplicates automatically)
                CourseRegistration::firstOrCreate(
                    [
                        'student_id' => $student->id,
                        'course_id' => $course->id,
                        'academic_session_id' => $sessionId,
                        'semester_id' => $semesterId,
                    ],
                    [
                        'level_id' => $levelId,
                        'programme_id' => $programmeId,
                        'course_option_id' => $student->course_option_id ?? $course->course_option_id,
                        'registered_by' => $this->registeredBy,
                    ]
                );
            }
        }
    }
}
