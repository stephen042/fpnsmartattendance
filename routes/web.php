<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/student', function () {
    return view('welcome');
})->name('student.login');


require __DIR__ . '/settings.php';
require __DIR__ . '/super_admin.php';
require __DIR__ . '/students.php';
require __DIR__ . '/admin.php';
require __DIR__ . '/lecturer.php';
