<?php

namespace App\Models\Organization;

use App\Core\Models\MyModel;
use Illuminate\Support\Facades\DB;
use App\Models\Employees\Employee;
use App\Models\Auth\UserProfile;
use App\Models\Employees\EmployeeExperience;
use App\Models\Employees\EmployeeMutation;
use App\Models\Recruitment\Vacancy;

class Division extends MyModel{

    protected $table = 'employee_divisions';
    protected $fillable = [
        'code',
        'name',
        'description',
        'superior_id'
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                'employee_divisions.id',
                'employee_divisions.code',
                'employee_divisions.name AS divison_name',
                 DB::raw("CONCAT(first_name,' ',last_name) as employee_name"),
                'employee_divisions.created_at'
            ),
            "filter"=> array(
                'employee_divisions.id',
                'employee_divisions.code',
                'employee_divisions.name',
                "users_profile.first_name",
                'employee_divisions.created_at'
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            'employee_divisions.code AS KODE',
            'employee_divisions.name AS NAMA_DIVISI',
            DB::raw("CONCAT(first_name,' ',last_name) as NAMA_PIMPINAN"),
        ];
    }

    public static function defaultDivision(){
        $data = [
            "HUMAN RESOURCES",
            "ACCOUNTING AND FINANCE",
            "MARKETING AND ADVERTISING",
            "PRODUCTION",
            "INFORMATION TECHNOLOGY",
            "OPERATIONS",
            "CUSTOMER SERVICE",
            "PURCHASING",
            "LEGAL DEPARTMENT"
        ];
        sort($data);
        return $data;
    }

  
    
    public function Employee() {
        return $this->hasMany(Employee::class);
    }

    public function EmployeeExperience() {
        return $this->hasMany(EmployeeExperience::class);
    }

    public function Superior() {
        return $this->belongsTo(UserProfile::class, "superior_id", "user_id");
    }

    public function getEmployee() {
        return $this->belongsTo(Employee::class, "superior_id", "user_id");
    }

    protected function onJoin($db){
        $db->Leftjoin('users_profile', function($join) {
            $join->on('users_profile.user_id', '=', 'employee_divisions.superior_id');
        });
    }

    public function EmployeeMutation(){
        return $this->hasMany(EmployeeMutation::class);
    }

    public function Vacancy(){
        return $this->hasMany(Vacancy::class);
    }

}