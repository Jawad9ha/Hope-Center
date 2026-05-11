<?php
namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Device;
use App\Services\LoanService;
use Illuminate\Http\Request;

class LoanController extends Controller {
    protected $loanService;

    public function __construct(LoanService $loanService) {
        $this->loanService = $loanService;
    }

    public function create() {
        $employees = Employee::all();
        $devices = Device::where('status', 'available')->get();
        return view('loans.create', compact('employees', 'devices'));
    }

    public function store(Request $request) {
        $request->validate([
            'employee_id' => 'required|exists:employees,id',
            'device_id' => 'required|exists:devices,id'
        ]);

        try {
            $employee = Employee::findOrFail($request->employee_id);
            $device = Device::findOrFail($request->device_id);
            $this->loanService->createLoan($employee, $device);
            return redirect()->route('dashboard')->with('success', 'Device loaned successfully');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function return($loanId) {
        $loan = \App\Models\Loan::findOrFail($loanId);
        $this->loanService->returnDevice($loan);
        return redirect()->route('dashboard')->with('success', 'Device returned and pending inspection');
    }
}