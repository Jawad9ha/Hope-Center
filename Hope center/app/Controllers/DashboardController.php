<?php
namespace App\Http\Controllers;

use App\Models\Loan;

class DashboardController extends Controller {
    public function index() {
        $activeLoans = Loan::with(['employee', 'device'])
            ->where('status', 'active')
            ->get();

        $pendingLoans = Loan::with(['employee', 'device'])
            ->where('status', 'pending_inspection')
            ->get();

        return view('dashboard', compact('activeLoans', 'pendingLoans'));
    }
}