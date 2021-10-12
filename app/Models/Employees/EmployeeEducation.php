<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Core\Country;
use App\Models\Master\EducationQualification;


class EmployeeEducation extends Model{

    use SoftDeletes;

    protected $dates =['deleted_at'];
    protected $table = 'employee_education';
    protected $fillable = [
        "candidate_id",
        "employee_id",
        "school_name",
        "month_start",
        "year_start",
        "month_end",
        "year_end",
        "qualification_id",
        "country_id",
        "specliationation",
        "department",
        "regency_id",
        "score",
        "scale",
        "description"
    ];

    public function Qualification(){
        return $this->belongsTo(EducationQualification::class, "qualification_id");
    }

    public function Country(){
        return $this->belongsTo(Country::class, "country_id");
    }

   
}