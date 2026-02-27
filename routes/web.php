<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('pages.auth.login');
})->name('home');


require __DIR__ . '/settings.php';
require __DIR__ . '/super_admin.php';
require __DIR__ . '/students.php';
require __DIR__ . '/admin.php';
