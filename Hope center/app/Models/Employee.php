<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model {
    protected $fillable = ['name', 'email', 'branch_id'];

    public function branch() { return $this->belongsTo(Branch::class); }
    public function loans() { return $this->hasMany(Loan::class); }
}