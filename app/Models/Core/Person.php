<?php

namespace App\Models\Core;

use App\Core\Models\MyModel;

class Person extends MyModel{

    protected $table = 'users';
    protected $fillable = [
        'username',
        'email',
        'phone',
        'password'
    ];

    public function datatableConfig(){
        return [
            "column"=> array("id","username","email","phone","access_groups","created_at"),
            "filter"=> array("id","username","email","phone","access_groups","created_at"),
        ];
    }

    public function exportDataColumn(){
        return [
            "users.username AS USERNAME",
            "users.email AS EMAIL",
            "users.phone AS NOMOR_TELEPON",
            "users.access_groups AS AKSES"
        ];
    }

    protected function onWhere($db){
        $db->where("users.id","!=",\Auth::User()->id);
        $db->where("users.is_root", 0);
    }
}