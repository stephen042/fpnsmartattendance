<?php

use Illuminate\Support\Facades\Route;

// Admin 
Route::middleware(['auth', 'admin'])->group(function () {
    Route::view('dashboard', 'admin.dashboard')->name('dashboard');

    Route::view('student-enrollment', 'admin.enrollment')->name('student-enrollment');
    Route::view('student-edit/{id}', 'admin.edit-student')->name('edit-student');

    Route::view('create-level', 'admin.create-level')->name('create-level');
});
