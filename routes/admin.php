<?php

use Illuminate\Support\Facades\Route;

// Admin
Route::view('hod', 'pages.auth.login')->name('hod-login');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');

    Route::view('student-enrollment', 'admin.enrollment')->name('student-enrollment');
    Route::get(
        'student-edit/{id}/edit',
        fn ($id) => view('admin.edit-student', compact('id'))
    )->name('edit-student');

    Route::view('create-level', 'admin.create-level')->name('create-level');

    Route::view('manage-courses', 'admin.manage-courses')->name('manage-courses');

    Route::view('manage-lecturers', 'admin.manage-lecturers')->name('manage-lecturers');
    Route::view('edit-lecturer/{id}/edit', 'admin.edit-lecturers')->name('edit-lecturer');

    Route::view('manage-courses-assignment', 'admin.manage-courses-assignment')->name('manage-courses-assignment');
    Route::view('edit-lecturer-data/{id}/edit', 'admin.edit-lecturer-data')->name('edit-lecturer-data');

    Route::view('course-registration-students', 'admin.course-registration-students')->name('course-registration-students');
    Route::view('edit-course-registration/{id}/edit', 'admin.edit-course-registration')->name('edit-course-registration');

    Route::view('settings', 'admin.settings')->name('settings');
});
