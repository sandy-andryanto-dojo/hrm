<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;
use App\Models\Recruitment\Vacancy;

class Job extends MyModel{

    protected $table = 'employee_jobs';
    protected $fillable = [
        'code',
        'name',
        'description'
    ];

    public function datatableConfig(){
        return [
            "column"=> array("id","code","name","description","created_at"),
            "filter"=> array("id","code","name","description","created_at"),
        ];
    }

    public function exportDataColumn(){
        return [
            "employee_jobs.code AS KODE_PROFESSI",
            "employee_jobs.name AS NAMA",
            "employee_jobs.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "Pegawai Kantoran",
            "Petugas Resepsionis / Penerima Tamu",
            "Petugas Keamanan",
            "Office Boy (OB) / Cleaning Service",
            "Teknisi",
            "Petugas Parkir",
            "Operator Telepon",
            "Pedagang",
            "Supir / Sopir",
            "Petugas Taman",
            "Pengelola Gedung",
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