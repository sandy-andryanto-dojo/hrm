<?php

namespace App\Models\Core;

use App\Core\Models\MyModel;
use App\Models\Core\Regency;
use App\Models\Core\Village;

class District extends MyModel{

    protected $table = 'districts';
    protected $fillable = [
        'regency_id',
        'regency_code',
        'code',
        'name'
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                "districts.id",
                "provinces.name as province_name",
                "regencies.name as regency_name",
                "districts.name",
                "districts.created_at"
            ),
            "filter"=> array(
                "districts.id",
                "provinces.name",
                "regencies.name",
                "districts.name",
                "districts.created_at"
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            "provinces.name as PROVINSI",
            "regencies.name as KABUPATEN_KOTA",
            "districts.name as KECAMATAN",
        ];
    }

    protected function onJoin($db){
        $db->join('regencies', function($join) {
            $join->on('regencies.id', '=', 'districts.regency_id');
        });
        $db->join('provinces', function($join) {
            $join->on('provinces.id', '=', 'regencies.province_id');
        });
    }

    public function Regency() {
        return $this->belongsTo(Regency::class);
    }

    public function Village() {
        return $this->hasMany(Village::class);
    }

}