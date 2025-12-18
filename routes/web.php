<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AuthController;

// 1. Route cho Khách (Chưa đăng nhập)
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);

// 2. Route yêu cầu Đăng Nhập (Phải login mới vào được)
Route::middleware(['auth'])->group(function () {
    
    // Trang chủ chuyển hướng vào tasks
    Route::get('/', function () {
        return redirect()->route('tasks.index');
    });
    
    // CRUD Tasks
    Route::resource('tasks', TaskController::class);

    // Đăng xuất
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});
