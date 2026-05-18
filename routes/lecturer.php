<?php 

use Illuminate\Support\Facades\Route;

Route::view('lecturer', 'pages.auth.login')->name('lecturer-login');

Route::middleware(['auth', 'lecturer'])->group(function () {
    Route::view('lecturer-dashboard', 'lecturer.dashboard')->name('lecturer.dashboard');
    Route::view('/lecturer-dashboard/{session}/class-details', 'lecturer.classdetails')->name('lecturer.classdetails');

    Route::view('lecturer-logs', 'lecturer.logs')->name('lecturer.logs');
    Route::view('lecturer-logs/{course}/course-details', 'lecturer.coursedetails')->name('lecturer.coursedetails');
});

