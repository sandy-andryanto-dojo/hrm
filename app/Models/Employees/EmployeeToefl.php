<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeToefl extends Model{

    use SoftDeletes;

    protected $dates =['deleted_at'];
    protected $table = 'employee_toefl';
    protected $fillable = [
        "candidate_id",
        "employee_id",
        "language",
        "level",
        "write",
        "listen",
        "read",
        "score",
        "scale",
        "description"
    ];
   
}