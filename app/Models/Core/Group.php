<?php

namespace App\Models\Core;

use App\Core\Models\MyModel;

class Group extends MyModel{

    protected $table = 'roles';
    protected $fillable = [
        'name',
        'description',      
    ];
    
    public function datatableConfig(){
        return [
            "column"=> array("id","name","created_at"),
            "filter"=> array("id","name","created_at"),
        ];
    }

    
    public function exportDataColumn(){
        return [
            "name as NAMA_AKSES_PENGGUNA",
        ];
    }

    protected function onWhere($db){
        $db->where("name","!=","Admin");
    }


}