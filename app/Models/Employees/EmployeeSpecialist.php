<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeSpecialist extends Model{

    use SoftDeletes;

    protected $dates =['deleted_at'];
    protected $table = 'employee_specialist';
    protected $fillable = [
        "candidate_id",
        "employee_id",
        "name",
        "description",
        "level", 
    ];
   
}