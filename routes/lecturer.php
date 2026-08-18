<?php

use App\Models\AttendanceSession;
use App\Models\Course;
use Illuminate\Support\Facades\Route;

Route::view('lecturer', 'pages.auth.login')->name('lecturer-login');

Route::middleware(['auth', 'lecturer'])->group(function () {
    Route::view('lecturer-dashboard', 'lecturer.dashboard')->name('lecturer.dashboard');
    Route::get('/lecturer-dashboard/{session}/class-details', function (AttendanceSession $session) {
        return view('lecturer.classdetails', compact('session'));
    })->name('lecturer.classdetails');

    Route::view('lecturer-logs', 'lecturer.logs')->name('lecturer.logs');
    Route::get('lecturer-logs/{course}/course-details', function (Course $course) {
        return view('lecturer.coursedetails', [
            'course' => $course,
        ]);
    })->name('lecturer.coursedetails');
});
