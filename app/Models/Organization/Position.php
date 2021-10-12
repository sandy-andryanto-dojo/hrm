<?php

namespace App\Models\Organization;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeExperience;
use App\Models\Employees\EmployeePromotion;
use App\Models\Recruitment\Vacancy;

class Position extends MyModel{

    protected $table = 'employee_positions';
    protected $fillable = [
        'code',
        'name',
        'hour_salary',
        'month_salary',
        'level',
        'description'
    ];

    public function datatableConfig(){
        return [
            "column"=> array("id","code","name","hour_salary","month_salary","level","created_at"),
            "filter"=> array("id","code","name","hour_salary","month_salary","level","created_at"),
        ];
    }

    public function exportDataColumn(){
        return [
            "employee_positions.code AS KODE_POSISI",
            "employee_positions.name AS NAMA",
            "employee_positions.hour_salary AS GAJI_PER_JAM",
            "employee_positions.month_salary AS GAJI_BULANAN",
            "employee_positions.level AS GOLONGAN",
            "employee_positions.description AS DESKRIPSI"
        ];
    }

    public static function defaultPosition(){
        $data = [
            "Operations Manager",
            "Quality Control",
            "Accountant",
            "Office Manager",
            "Receptionist",
            "Supervisor",
            "Marketing Manager",
            "Purchasing Manager",
            "Shipping and Receiving Manager",
            "Professional Staff",
            "Chief Executive Officer",
            "General Manager",
            "Chief Financial Officer",
            "Production Manager",
            "Project Manager"
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

    public function EmployeePromotion() {
        return $this->hasMany(EmployeePromotion::class);
    }

    public function Vacancy(){
        return $this->hasMany(Vacancy::class);
    }

}