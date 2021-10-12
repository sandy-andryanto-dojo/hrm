<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Employees\EmployeeExperience;

class Specialization extends MyModel{

    protected $table = 'employee_specliationations';
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
            "employee_specliationations.name AS NAMA",
            "employee_specliationations.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
           "Arsitek",
           "Apoteker",
           "Akuntan",
           "Selebritis",
           "Atlet",
           "Bidan",
           "Dokter",
           "Dosen",
           "Direktur",
           "Desainer",
           "Guru",
           "Hakim",
           "Jaksa",
           "Kasir",
           "Kondektur",
           "Koki",
           "Karyawan",
           "Masinis",
           "Model",
           "Nelayan",
           "Novelis",
           "Nakhoda",
           "Pegawai Negeri Sipil",
           "Penyanyi",
           "Pengacara",
           "Programmer",
           "Polisi",
           "Pramugari",
           "Perawat",
           "Penerjemah",
           "Pilot",
           "Pramusaji",
           "Presiden",
           "Penari",
           "Pemadam Kebakaran",
           "Pelayan",
           "Petani/Pekebun",
           "Resepsionis",
           "Satpam",
           "Seniman",
           "Sopir",
           "Sekretaris",
           "Tentara",
           "Video-editor",
           "Wartawan",
        ];
        sort($data);
        return $data;
    }

    public function EmployeeExperience() {
        return $this->hasMany(EmployeeExperience::class);
    }

}