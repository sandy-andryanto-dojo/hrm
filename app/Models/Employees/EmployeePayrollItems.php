<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

class EmployeePayrollItems extends Model{

    protected $table = 'employee_payroll_items';
    protected $fillable = [
        "payroll_id",
        "model_type",
        "model_id",
        "cost"
    ];

}