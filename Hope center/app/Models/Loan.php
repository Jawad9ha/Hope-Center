<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Loan extends Model {
    protected $fillable = ['employee_id', 'device_id', 'loaned_at', 'returned_at', 'status', 'inspection_notes', 'inspected_by'];

    protected $casts = [
        'loaned_at' => 'datetime',
        'returned_at' => 'datetime',
    ];

    public function employee() { return $this->belongsTo(Employee::class); }
    public function device() { return $this->belongsTo(Device::class); }
    public function inspector() { return $this->belongsTo(Employee::class, 'inspected_by'); }
}