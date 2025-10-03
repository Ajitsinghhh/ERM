<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\HRManagerController;
use App\Http\Controllers\PasswordController;
use App\Http\Controllers\TaskController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Security test route (remove in production)
Route::get('/security-test', function () {
    $user = \Illuminate\Support\Facades\Auth::user();
    return response()->json([
        'authenticated' => \Illuminate\Support\Facades\Auth::check(),
        'user' => $user ? [
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'employee_role' => $user->employee_role,
            'is_admin' => $user->isAdmin(),
            'is_hr_manager' => $user->isHRManager(),
        ] : null
    ]);
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Admin Dashboard Route
Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('admin');

// Admin User Management Routes
Route::prefix('admin')->middleware('admin')->group(function () {
    Route::resource('users', \App\Http\Controllers\UserController::class)->names([
        'index' => 'admin.users.index',
        'create' => 'admin.users.create',
        'store' => 'admin.users.store',
        'show' => 'admin.users.show',
        'edit' => 'admin.users.edit',
        'update' => 'admin.users.update',
        'destroy' => 'admin.users.destroy'
    ]);
    Route::post('users/{user}/toggle-status', [\App\Http\Controllers\UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
});

// HR Dashboard Route - Protected by specific role middleware
Route::get('/hr/dashboard', [HRManagerController::class, 'dashboard'])->name('hr.dashboard')->middleware('hr_manager');

// HR Employee Management Routes
Route::middleware('hr_manager')->group(function () {
    Route::get('/hr/employee-registration', [HRManagerController::class, 'showRegistrationForm'])->name('hr.employee-registration');
    Route::post('/hr/employee-registration', [HRManagerController::class, 'registerEmployee'])->name('hr.employee-registration.store');
    
    // Export employees (must be before resource route)
    Route::get('/hr/employees/export', [HRManagerController::class, 'exportEmployees'])->name('hr.employees.export');
    
    // Import employees (must be before resource route)
    Route::get('/hr/employees/import', [HRManagerController::class, 'showImportForm'])->name('hr.employees.import');
    Route::post('/hr/employees/import', [HRManagerController::class, 'importEmployees'])->name('hr.employees.import.store');
    Route::get('/hr/employees/template', [HRManagerController::class, 'downloadTemplate'])->name('hr.employees.template');
    
    // Global search for HR
    Route::get('/hr/search', [HRManagerController::class, 'search'])->name('hr.search');
    
    // Employee Management (resource route - must be last)
    Route::resource('hr/employees', HRManagerController::class)->names([
        'index' => 'hr.employees.index',
        'show' => 'hr.employees.show',
        'edit' => 'hr.employees.edit',
        'update' => 'hr.employees.update',
        'destroy' => 'hr.employees.destroy'
    ]);
    
    // Toggle employee status
    Route::post('hr/employees/{employee}/toggle-status', [HRManagerController::class, 'toggleStatus'])->name('hr.employees.toggle-status');
});

// Password Management Routes - Admin Only
Route::middleware(['auth'])->group(function () {
    Route::resource('passwords', PasswordController::class);
    Route::post('passwords/{password}/toggle-favorite', [PasswordController::class, 'toggleFavorite'])->name('passwords.toggle-favorite');
    Route::get('passwords/{password}/copy', [PasswordController::class, 'copyPassword'])->name('passwords.copy');
});

// Task Management Routes - HR Manager and Admin Only
Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class);
    Route::post('tasks/{task}/update-status', [TaskController::class, 'updateStatus'])->name('tasks.update-status');
    Route::get('tasks-stats', [TaskController::class, 'getStats'])->name('tasks.stats');
});

