<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Employees\EmployeeCut;


class LossType extends MyModel{

    protected $table = 'employee_loss_type';
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
            "employee_loss_type.name AS NAMA",
            "employee_loss_type.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "Pajak Penghasilan",
            "BPJS Kesehatan",
            "Jaminan Pensiun",
            "Jaminan Hari Tua",
            "Potongan Kehadiran",
            "Kecelakaan Kerja dan Jaminan Kematian"
        ];
        sort($data);
        return $data;
    }

    public function EmployeeCut() {
        return $this->hasMany(EmployeeCut::class);
    }

   

}