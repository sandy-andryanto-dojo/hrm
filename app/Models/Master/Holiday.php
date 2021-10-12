<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;

class Holiday extends MyModel{

    protected $table = 'holidays';
    protected $fillable = [
        'name',
        'date_holiday',
        'description',
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                'id',
                'name',
                'date_holiday',
                'description',
                'created_at'
            ),
            "filter"=> array(
                'id',
                'name',
                'date_holiday',
                'description',
                'created_at'
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            'name AS NAMA_HARI_LIBUR',
            'date_holiday AS TANGGAL',
            'description AS KETERANGAN',
        ];
    }

   

}