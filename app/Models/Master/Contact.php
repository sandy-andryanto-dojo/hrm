<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;

class Contact extends MyModel{

    protected $table = 'contacts';
    protected $fillable = [
        'name',
        'email',
        'phone',
        'website',
        'postal_code',
        'address'
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                'id',
                'name',
                'email',
                'phone',
                'website',
                'postal_code',
                'address',
                'created_at'
            ),
            "filter"=> array(
                'id',
                'name',
                'email',
                'phone',
                'website',
                'postal_code',
                'address',
                'created_at'
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            'name AS NAMA',
            'email AS EMAIL',
            'phone AS NOMOR_TELEPON',
            'website AS WEBSITE',
            'postal_code AS KODE_POS',
            'address AS ALAMAT'
        ];
    }

   

}