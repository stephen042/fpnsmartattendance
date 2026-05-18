<?php 

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

// Students Only
Route::middleware(['student'])->group(function () {
    // Route::get('/student/dashboard', function () { return "Welcome Student"; })->name('student.dashboard');
    Route::view('/student/dashboard', 'students.dashboard')->name('student.dashboard');
    Route::view('/student/{course_id}/logs', 'students.logs')->name('student-logs');
    Route::post('/student/logout', function () {
        Auth::logout();
        return redirect('/');
    })->name('student.logout');

});