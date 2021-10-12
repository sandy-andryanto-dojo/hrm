<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employees\Employee;
use App\Models\Master\LossType;

class EmployeeCut extends Model{

    public $timestamps = false;
    protected $table = 'employee_cuts';
    protected $fillable = [
        'type_id',
        'employee_id',
        'is_active',
        'cost',
    ];

    public function Employee() {
        return $this->belongsTo(Employee::class, "employee_id");
    }

    public function Type() {
        return $this->belongsTo(LossType::class, "type_id");
    }
    
}