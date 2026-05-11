<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Device extends Model {
    protected $fillable = ['name', 'type', 'status', 'condition_at_checkout', 'purchase_date'];

    public function loans() { return $this->hasMany(Loan::class); }

    public function isAvailable() {
        return $this->status === 'available';
    }
}