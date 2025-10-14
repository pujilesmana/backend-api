<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\AuthController;

// Route::get('/users', [UserController::class, 'index']); // Get all users
// Route::get('/users/{id}', [UserController::class, 'show']); // Get user by ID (ORM)
// Route::get('/users/manual/{id}', [UserController::class, 'showManual']); // Get user by ID (manual query)
// Route::post('/users', [UserController::class, 'store']); // Create new user
// Route::put('/users/{id}', [UserController::class, 'update']); // Update user
// Route::delete('/users/{id}', [UserController::class, 'destroy']); // Delete user

// Route untuk mendapatkan token
Route::post('/auth/token', [AuthController::class, 'getToken']);

// Route dilindungi JWT
Route::middleware('jwt')->group(function () {
    Route::get('/users', [UserController::class, 'index']);
    Route::get('/users/{id}', [UserController::class, 'show']);
    Route::get('/users/manual/{id}', [UserController::class, 'showManual']);
    Route::post('/users', [UserController::class, 'store']);
    Route::put('/users/{id}', [UserController::class, 'update']);
    Route::delete('/users/{id}', [UserController::class, 'destroy']);
});