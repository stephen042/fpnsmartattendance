<?php 

use Illuminate\Support\Facades\Route;

// Super Admin Only
Route::middleware(['auth', 'super_admin'])->group(function () {
    Route::get('/super-admin/dashboard', function () { return "Welcome Super Admin"; });
});