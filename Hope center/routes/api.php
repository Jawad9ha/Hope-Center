<?php
use App\Http\Controllers\ReportController;

Route::get('/reports/heavy-users', [ReportController::class, 'heavyUsers']);
Route::get('/reports/idle-devices', [ReportController::class, 'idleDevices']);
Route::get('/reports/branch-inventory/{branchId}', [ReportController::class, 'branchInventory']);