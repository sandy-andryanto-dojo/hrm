<?php

namespace App\Models\Core;

use App\Core\Models\MyModel;
use App\Models\Core\Province;
use App\Models\Core\District;
use App\Models\Employees\EmployeeTravel;

class Regency extends MyModel{

    protected $table = 'regencies';
    protected $fillable = [
        'province_id',
        'province_code',
        'code',
        'name'
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                'regencies.id',
                'provinces.name as province_name',
                'regencies.name',
                'regencies.created_at'
            ),
            "filter"=> array(
                'regencies.id',
                'provinces.name',
                'regencies.name',
                'regencies.created_at'
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            'provinces.name AS PROVINSI',
            'regencies.name AS KABUPATEN_KOTA'
        ];
    }

    public function Province() {
        return $this->belongsTo(Province::class);
    }

    public function District() {
        return $this->hasMany(District::class);
    }

    public function EmployeeTravel() {
        return $this->hasMany(EmployeeTravel::class);
    }

    protected function onJoin($db){
        $db->join('provinces', function($join) {
            $join->on('provinces.id', '=', 'regencies.province_id');
        });
    }

}