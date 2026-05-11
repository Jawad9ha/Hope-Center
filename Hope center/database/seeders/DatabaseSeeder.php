<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\{Branch, Employee, Device, Loan};
use Carbon\Carbon;

class DatabaseSeeder extends Seeder {
    public function run(): void {
        Branch::create(['name' => 'Main HQ', 'location' => 'City A']);
        Branch::create(['name' => 'North Branch', 'location' => 'City B']);

        $emp1 = Employee::create(['name' => 'Jawad Haddad', 'email' => 'jawadhaddad188@gmail.com', 'branch_id' => 1]);
        $emp2 = Employee::create(['name' => 'Jawad Haddad', 'email' => 'jhaddad290.com', 'branch_id' => 2]);

        Device::create(['name' => 'Dell Laptop', 'type' => 'laptop', 'status' => 'available', 'purchase_date' => '2026-01-01']);
        Device::create(['name' => 'HP Printer', 'type' => 'printer', 'status' => 'available', 'purchase_date' => '2026-06-01']);
    }
}