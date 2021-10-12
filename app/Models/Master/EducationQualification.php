<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Employees\EmployeeEducation;

class EducationQualification extends MyModel{

    protected $table = 'employee_education_qualifications';
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
            "employee_education_qualifications.name AS NAMA",
            "employee_education_qualifications.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "TK",
            "SD",
            "SMP",
            "SMK",
            "D3",
            "D4",
            "S1",
            "S2",
            "S3"
        ];
        sort($data);
        return $data;
    }

    public function EmployeeEducation() {
        return $this->hasMany(EmployeeEducation::class);
    }

}