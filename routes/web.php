<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/debug-ip', function (Request $request) {
    return response()->json([
        'ip' => $request->ip(),
        'ips' => $request->ips(),
        'remote_addr' => $request->server('REMOTE_ADDR'),
        'x_real_ip' => $request->header('X-Real-IP'),
        'x_forwarded_for' => $request->header('X-Forwarded-For'),
        'host' => $request->getHost(),
    ]);
});

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
