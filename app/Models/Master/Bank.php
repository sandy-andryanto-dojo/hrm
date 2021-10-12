<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Core\Country;
use App\Models\Auth\UserProfile;

class Bank extends MyModel{

    protected $table = 'banks';
    protected $fillable = [
        'name',
        'country_id',
        'description',
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                'banks.id',
                'banks.name',
                'countries.name as country_name',
                'banks.description',
                'banks.created_at'
            ),
            "filter"=> array(
                'banks.id',
                'banks.name',
                'countries.name',
                'banks.description',
                'banks.created_at'
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            'banks.name AS NAMA_BANK',
            'countries.name AS NEGARA',
            'banks.description AS DESKRIPSI',
        ];
    }

    public function Country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    protected function onJoin($db){
        $db->leftJoin('countries', function($join) {
            $join->on('countries.id', '=', 'banks.country_id');
        });
    }

    public function UserProfile() {
        return $this->hasMany(UserProfile::class);
    }

}