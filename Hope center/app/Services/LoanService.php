<?php
namespace App\Services;

use App\Models\Employee;
use App\Models\Device;
use App\Models\Loan;
use App\Models\DamageReport;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class LoanService {

    public function hasActiveLoanOfSameType(Employee $employee, Device $device): bool {
        $activeLoans = $employee->loans()
            ->whereNull('returned_at')
            ->whereHas('device', function($q) use ($device) {
                $q->where('type', $device->type);
            })
            ->get();

        return $activeLoans->count() > 0;
    }

    public function createLoan(Employee $employee, Device $device): Loan {
        if (!$device->isAvailable()) {
            throw new \Exception('Device is not available');
        }

        if ($this->hasActiveLoanOfSameType($employee, $device)) {
            throw new \Exception('Employee already has an active loan of same device type');
        }

        return DB::transaction(function() use ($employee, $device) {
            $device->update(['status' => 'on_loan']);

            return Loan::create([
                'employee_id' => $employee->id,
                'device_id' => $device->id,
                'loaned_at' => Carbon::now(),
                'status' => 'active'
            ]);
        });
    }

    public function returnDevice(Loan $loan, array $inspectionNotes = null): void {
        DB::transaction(function() use ($loan, $inspectionNotes) {
            $loan->update([
                'returned_at' => Carbon::now(),
                'status' => 'pending_inspection',
                'inspection_notes' => $inspectionNotes
            ]);

            $loan->device->update(['status' => 'pending_inspection']);
        });
    }

    public function inspectDevice(Loan $loan, bool $isDamaged, string $notes, Employee $inspector): void {
        DB::transaction(function() use ($loan, $isDamaged, $notes, $inspector) {
            $loan->update([
                'status' => 'completed',
                'inspected_by' => $inspector->id,
                'inspection_notes' => $notes
            ]);

            if ($isDamaged) {
                $loan->device->update(['status' => 'under_maintenance']);
                DamageReport::create([
                    'loan_id' => $loan->id,
                    'description' => $notes,
                    'reported_by' => $inspector->id
                ]);
            } else {
                $loan->device->update(['status' => 'available']);
            }
        });
    }
}