<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\Bank;
use App\Models\Core\Province;
use App\Models\Employees\EmployeeExperience;
use App\Models\Employees\EmployeeEducation;
use App\Models\Employees\EmployeeTravel;
use App\Models\Auth\UserProfile;
use App\Models\Recruitment\Candidate;

class Country extends Model{

    protected $table = 'countries';
    protected $fillable = [
        'iso_code',
        'lang_code',
        'currency_code',
        'name',
        'capital_city_id'
    ];

    public function Bank() {
        return $this->hasMany(Bank::class);
    }

    public function Province() {
        return $this->hasMany(Province::class);
    }

    public function EmployeeExperience() {
        return $this->hasMany(EmployeeExperience::class);
    }

    public function EmployeeEducation() {
        return $this->hasMany(EmployeeEducation::class);
    }

    public function EmployeeTravel() {
        return $this->hasMany(EmployeeTravel::class);
    }

    public function UserProfile() {
        return $this->hasMany(UserProfile::class);
    }

    public static function getAllLanguages(){
        $result = array();
        $file_json = base_path().'/data_seeds/languages.json';
        $string = file_get_contents($file_json);
        $json = json_decode($string, true);
        foreach($json as $key => $row){
            $language = $json[$key];
            $result[$language["name"]] = $language["name"];
        }
        return $result;
    }

    public function Candidate() {
        return $this->hasMany(Candidate::class);
    }
}