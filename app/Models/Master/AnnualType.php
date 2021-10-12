<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Employees\EmployeeAnnual;

class AnnualType extends MyModel{

    protected $table = 'employee_annual_type';
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
            "employee_annual_type.name AS NAMA",
            "employee_annual_type.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "Cuti Karyawan Tahunan",
            "Cuti Sakit",
            "Cuti Hamil",
            "Cuti Besar",
            "Cuti Penting",
            "Cuti Bersama",
            "Cuti Berbayar"
        ];
        sort($data);
        return $data;
    }

    public function EmployeeAnnual() {
        return $this->hasMany(EmployeeAnnual::class);
    }

}