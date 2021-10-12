<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\UserProfile;
use App\Models\Recruitment\Candidate;

class UserGender extends Model{

    use SoftDeletes;

    protected $dates =['deleted_at'];
    protected $table = 'users_genders';
    protected $fillable = [
        'name',
        'description',
    ];

    public function TableName() {
        return with(new static)->getTable();
    }

    public function Profile() {
        return $this->hasMany(UserProfile::class);
    }

    public static function createDefault(){
        $items = ["Pria", "Wanita"];
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