<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Device;
use App\Models\Loan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller {

    public function heavyUsers() {
        $sixMonthsAgo = Carbon::now()->subMonths(6);

        $employees = Employee::withCount(['loans' => function($q) use ($sixMonthsAgo) {
            $q->where('loaned_at', '>=', $sixMonthsAgo)
              ->select(DB::raw('COUNT(DISTINCT device_id)'));
        }])->having('loans_count', '>', 3)->get();

        return response()->json($employees);
    }

    public function idleDevices() {
        $oneYearAgo = Carbon::now()->subYear();

        $devices = Device::whereDoesntHave('loans', function($q) use ($oneYearAgo) {
            $q->where('loaned_at', '>=', $oneYearAgo);
        })->get();

        foreach ($devices as $device) {
            $lastLoan = $device->loans()->latest('loaned_at')->first();
            $device->days_in_stock = $lastLoan ? Carbon::now()->diffInDays($lastLoan->returned_at ?? $lastLoan->loaned_at) : null;
        }

        return response()->json($devices);
    }

    public function branchInventory($branchId) {
    $devices = Device::whereHas('loans', function($q) use ($branchId) {
        $q->whereHas('employee', function($q2) use ($branchId) {
            $q2->where('branch_id', $branchId);
        })->where('condition_at_checkout', 'excellent');
    })->with('loans.employee')->get();

    $grouped = $devices->groupBy('type')->map->count();
    
    return response()->json($grouped);
}
}