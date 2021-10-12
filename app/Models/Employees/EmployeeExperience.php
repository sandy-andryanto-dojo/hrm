<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;

use App\Models\Organization\Division;
use App\Models\Organization\Position;
use App\Models\Master\Specialization;
use App\Models\Master\Industry;
use App\Models\Core\Country;
use App\Models\Core\Currency;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeExperience extends Model{

    use SoftDeletes;

    protected $table = 'employee_experience';
    protected $fillable = [
        "candidate_id",
        "employee_id",
        "position_id",
        "company_name",
        "month_start",
        "year_start",
        "month_end",
        "year_end",
        "specliationation_id",
        "division_id",
        "country_id",
        "industry_id",
        "currency_id",
        "sallary",
        "description"
    ];

    public function Division(){
        return $this->belongsTo(Division::class, "division_id");
    }

    public function Position(){
        return $this->belongsTo(Position::class, "position_id");
    }

    public function Specialization(){
        return $this->belongsTo(Specialization::class, "specliationation_id");
    }

    public function Industry(){
        return $this->belongsTo(Industry::class, "industry_id");
    }

    public function Country(){
        return $this->belongsTo(Country::class, "country_id");
    }

    public function Currency(){
        return $this->belongsTo(Currency::class, "currency_id");
    }

}