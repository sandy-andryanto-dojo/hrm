<?php

namespace App\Models\Auth;

use App\Core\Models\MyModel;
use App\Models\Auth\UserProfile;
use App\Models\Recruitment\Candidate;

class UserMaritalStatus extends MyModel{

    protected $table = 'users_marital_status';
    protected $fillable = [
        'name',
        'description',
    ];

    public function datatableConfig(){
        return [
            "column"=> array("id","name","description","created_at"),
            "filter"=> array("id","name","description","created_at"),
        ];
    }

    public function exportDataColumn(){
        return [
            "users_marital_status.name AS NAMA",
            "users_marital_status.description AS DESKRIPSI"
        ];
    }

    public function Profile() {
        return $this->hasMany(UserProfile::class);
    }

    public static function createDefault(){
        $items = ["Belum Menikah", "Sudah Menikah", "Janda / Duda", "Cerai"];
        foreach($items as $row){
            self::create([
                "name"=>$row,
                "description"=>"-"
            ]);
        }
    }


    public function Candidate() {
        return $this->hasMany(Candidate::class);
    }

}