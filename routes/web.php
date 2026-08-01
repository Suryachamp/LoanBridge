<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;

Route::get('/', [LeadController::class, 'index']);

// Admin Auth Routes
Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::post('/admin/logout', [AuthController::class, 'logout'])->name('logout');

// Protected Admin Routes
Route::middleware('auth')->group(function () {
    Route::get('/admin', [AdminController::class, 'index']);
    Route::get('/admin/leads', [AdminController::class, 'leads']);
    Route::get('/admin/rules', [AdminController::class, 'rules']);
    Route::post('/admin/rules', [AdminController::class, 'storeRule']);
    Route::put('/admin/rules/{id}', [AdminController::class, 'updateRule']);
    Route::delete('/admin/rules/{id}', [AdminController::class, 'deleteRule']);
});
