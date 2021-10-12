<?php

namespace App\Models\Auth;

use App\Core\Models\MyModel;
use App\Models\Auth\UserProfile;
use App\Models\Recruitment\Candidate;

class UserIdentityType extends MyModel{

    protected $table = 'users_identity_types';
    protected $fillable = [
        'name',
        'description'
    ];

    public function datatableConfig(){
        return [
            "column"=> array("id","name","description","created_at"),
            "filter"=> array("id","name","description","created_at"),
        ];
    }

    public function exportDataColumn(){
        return [
            "users_identity_types.name AS NAMA",
            "users_identity_types.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "SIM",
            "KTP",
            "NPWP",
            "Passport"
        ];
        sort($data);
        return $data;
    }

    public function UserProfile() {
        return $this->hasMany(UserProfile::class);
    }

    public function Candidate() {
        return $this->hasMany(Candidate::class);
    }
}