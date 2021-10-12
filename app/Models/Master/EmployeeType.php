<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;
use App\Models\Recruitment\Vacancy;

class EmployeeType extends MyModel{

    protected $table = 'employee_type';
    protected $fillable = [
        'name',
        'description'
    ];

    public function datatableConfig(){
        return [
            "column"=> array("id","name","description","created_at"),
            "filter"=> array("id","name","description","created_at"),
        ];
    }

    public function exportDataColumn(){
        return [
            "employee_type.name AS NAMA",
            "employee_type.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "Karyawan Tetap",
            "Karyawan Kontrak",
            "Karyawan Magang",
        ];
        sort($data);
        return $data;
    }

    public function Employee() {
        return $this->hasMany(Employee::class);
    }

    public function Vacancy(){
        return $this->hasMany(Vacancy::class);
    }
}