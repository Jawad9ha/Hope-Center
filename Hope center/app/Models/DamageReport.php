<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DamageReport extends Model
{
    protected $fillable = ['loan_id', 'description', 'reported_by'];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function reporter()
    {
        return $this->belongsTo(Employee::class, 'reported_by');
    }
}