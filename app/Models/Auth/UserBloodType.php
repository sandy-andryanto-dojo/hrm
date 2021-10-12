<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Auth\UserProfile;
use App\Models\Recruitment\Candidate;

class UserBloodType extends Model{

    use SoftDeletes;

    protected $dates =['deleted_at'];
    protected $table = 'users_blood_types';
    protected $fillable = [
        'name',
        'description',
    ];

    public function TableName() {
        return with(new static)->getTable();
    }

    public static function createDefault(){
        $items = ["A","B","AB","O"];
        foreach($items as $row){
            self::create([
                "name"=>$row,
                "description"=>"-"
            ]);
        }
    }

    public function Profile() {
        return $this->hasMany(UserProfile::class);
    }

    public function Candidate() {
        return $this->hasMany(Candidate::class);
    }
}