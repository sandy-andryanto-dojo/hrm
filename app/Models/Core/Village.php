<?php

namespace App\Models\Core;

use App\Core\Models\MyModel;
use App\Models\Core\District;

class Village extends MyModel{

    protected $table = 'villages';
    protected $fillable = [
        'district_id',
        'district_code',
        'code',
        'name'
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                "villages.id",
                "provinces.name as province_name",
                "regencies.name as regency_name",
                "districts.name as district_name",
                "villages.name",
                "villages.created_at"
            ),
            "filter"=> array(
                "villages.id",
                "provinces.name",
                "regencies.name",
                "districts.name",
                "villages.name",
                "villages.created_at"
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            "provinces.name as PROVINSI",
            "regencies.name as KABUPATEN_KOTA",
            "districts.name as KECAMATAN",
            "villages.name as KELURAHAN"
        ];
    }

    protected function onJoin($db){
        $db->join('districts', function($join) {
            $join->on('districts.id', '=', 'villages.district_id');
        });
        $db->join('regencies', function($join) {
            $join->on('regencies.id', '=', 'districts.regency_id');
        });
        $db->join('provinces', function($join) {
            $join->on('provinces.id', '=', 'regencies.province_id');
        });
    }

    public function District() {
        return $this->belongsTo(District::class);
    }

}