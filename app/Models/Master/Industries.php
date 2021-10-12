<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Employees\EmployeeExperience;

class Industries extends MyModel{

    protected $table = 'employee_industries';
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
            "employee_industries.name AS NAMA",
            "employee_industries.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "Makanan, dan minuman",
            "Tembakau",
            "Tekstil",
            "Pakaian jadi",
            "Kulit, dan barang dari kulit",
            "Kayu, barang dari kayu, dan anyaman",
            "Kertas, dan barang dari kertas",
            "Penerbitan, percetakan, dan reproduksi",
            "Batu bara, minyak, dan gas bumi, dan bahan bakar dari nuklir",
            "Kimia, dan barang-barang dari bahan kimia",
            "Karet, dan barang-barang dari plastik",
            "Barang galian bukan logam",
            "Logam dasar",
            "Barang-barang dari logam, dan peralatannya",
            "Mesin, dan perlengkapannya",
            "Peralatan kantor, akuntansi, dan pengolahan data",
            "Mesin listrik lainnya, dan perlengkapannya",
            "Radio, televisi, dan peralatan komunikasi",
            "Peralatan kedokteran, alat ukur, navigasi, optik, dan jam",
            "Kendaraan bermotor",
            "Alat angkutan lainnya",
            "Furniture, dan industri pengolahan lainnya",
        ];
        sort($data);
        return $data;
    }

    public function EmployeeExperience() {
        return $this->hasMany(EmployeeExperience::class);
    }

}