<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\PatientController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\MedicalRecordController;

// Authentication
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware(['auth'])->group(function () {

    // Auto-redirection based on role
    Route::get('/', function () {
        $user = auth()->user();
        if ($user->role === 'admin')
            return redirect('/admin/dashboard');
        if ($user->role === 'receptionist')
            return redirect('/receptionist/dashboard');
        if ($user->role === 'doctor')
            return redirect('/doctor/dashboard');
        return view('welcome');
    });

    // Admin Routes
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'index']);
        Route::get('/staff', [AdminController::class, 'staff']);
        Route::get('/reports', [AdminController::class, 'index']); // Placeholder
    });

    // Receptionist / Shared Patient Management
    Route::middleware(['role:admin|receptionist'])->group(function () {
        Route::get('/receptionist/dashboard', [AdminController::class, 'index']); // Use shared logic
        Route::resource('patients', PatientController::class);
        Route::resource('appointments', AppointmentController::class);
        Route::patch('/appointments/{appointment}/status', [AppointmentController::class, 'updateStatus']);
    });

    // Doctor Routes
    Route::middleware(['role:doctor'])->prefix('doctor')->group(function () {
        Route::get('/dashboard', [DoctorController::class, 'index']);
        Route::get('/consultation/{patient}', [DoctorController::class, 'consultation']);
        Route::post('/medical-records', [MedicalRecordController::class, 'store']);
    });
});
