<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Employees\EmployeeAllowance;


class AllowanceType extends MyModel{

    protected $table = 'employee_allowance_type';
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
            "employee_allowance_type.name AS NAMA",
            "employee_allowance_type.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "Tunjangan Prestasi",
            "Tunjangan Pendidikan",
            "Tunjangan Kesehatan",
            "Tunjangan Transportasi",
            "Tunjangan Pensiun",
        ];
        sort($data);
        return $data;
    }

    public function EmployeeAllowance() {
        return $this->hasMany(EmployeeAllowance::class);
    }

}