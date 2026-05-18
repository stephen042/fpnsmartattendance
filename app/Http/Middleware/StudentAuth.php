<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Student;

class StudentAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)
    {
        if (!session('student_id')) {
            return redirect()->route('student.login');
        }

        $student = Student::find(session('student_id'));

        if (!$student || !$student->is_active) {
            session()->flush();
            return redirect()->route('student.login');
        }

        return $next($request);
    }
}
