<?php
use App\Http\Controllers\LoanController;
use App\Http\Controllers\DashboardController;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
Route::get('/loans/create', [LoanController::class, 'create'])->name('loans.create');
Route::post('/loans', [LoanController::class, 'store'])->name('loans.store');
Route::post('/loans/{loan}/return', [LoanController::class, 'return'])->name('loans.return');