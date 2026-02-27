<?php 

use Illuminate\Support\Facades\Route;

// Students Only
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/student/dashboard', function () { return "Welcome Student"; });
});