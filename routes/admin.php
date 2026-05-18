<?php

use Illuminate\Support\Facades\Route;

// Admin 
Route::view('hod', 'pages.auth.login')->name('hod-login');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');

    Route::view('student-enrollment', 'admin.enrollment')->name('student-enrollment');
    Route::view('student-edit/{id}/edit', 'admin.edit-student')->name('edit-student');

    Route::view('create-level', 'admin.create-level')->name('create-level');

    Route::view('manage-courses', 'admin.manage-courses')->name('manage-courses');

    Route::view('manage-lecturers', 'admin.manage-lecturers')->name('manage-lecturers');
    Route::view('edit-lecturer/{id}/edit', 'admin.edit-lecturers')->name('edit-lecturer');

    Route::view('manage-courses-assignment', 'admin.manage-courses-assignment')->name('manage-courses-assignment');
    Route::view('edit-courses-assignment/{id}/edit', 'admin.edit-courses-assignment')->name('edit-courses-assignment');
});
