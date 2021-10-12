<?php

namespace App\Models\Core;

use App\Core\Models\MyModel;
use App\Models\Core\Country;
use App\Models\Core\Regency;

class Province extends MyModel{

    protected $table = 'provinces';
    protected $fillable = [
        'country_id',
        'code',
        'name',
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                'provinces.id',
                'provinces.name',
                'provinces.created_at'
            ),
            "filter"=> array(
                'provinces.id',
                'provinces.name',
                'provinces.created_at'
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            'provinces.name AS PROVINSI'
        ];
    }

    public function Country() {
        return $this->belongsTo(Country::class);
    }

    public function Regency() {
        return $this->hasMany(Regency::class);
    }

}