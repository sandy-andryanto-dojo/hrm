<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employees\Employee;
use App\Models\Master\AllowanceType;

class EmployeeAllowance extends Model{

    public $timestamps = false;
    protected $table = 'employee_allowances';
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
        return $this->belongsTo(AllowanceType::class, "type_id");
    }
    
}