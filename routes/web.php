<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PayrollController;

Route::get('/', function () {
    return redirect()->route('employees.index');
});

// Employee routes
Route::resource('employees', EmployeeController::class);

// Payroll routes
Route::get('/payrolls', [PayrollController::class, 'index'])->name('payrolls.index');
Route::get('/payrolls/generate', [PayrollController::class, 'create'])->name('payrolls.create');
Route::post('/payrolls/generate', [PayrollController::class, 'store'])->name('payrolls.store');
Route::get('/payrolls/{payroll}', [PayrollController::class, 'show'])->name('payrolls.show');