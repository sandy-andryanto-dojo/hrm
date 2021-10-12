<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\User;
use App\Models\Auth\UserBloodType;
use App\Models\Auth\UserGender;
use App\Models\Auth\UserMaritalStatus;
use App\Models\Auth\UserIdentityType;
use App\Models\Core\Country;
use App\Models\Master\Bank;

class UserProfile extends Model{

    protected $table = 'users_profile';
    protected $fillable = [
        "user_id",
        "bank_id",
        "account_number",
        "identity_number",
        "tax_number",
        "medical_number",
        "family_number",
        "nick_name",
        "first_name",
        "last_name",
        "birth_date",
        "birth_place",
        "has_child",
        "total_child",
        "country_id",
        "gender_id",
        "status_id",
        "blood_id",
        "identity_id",
        "postal_code",
        "address",
        "about_me",
    ];

    protected $guarded = [];

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function Blood() {
        return $this->belongsTo(UserBloodType::class, 'blood_id');
    }

    public function Gender() {
        return $this->belongsTo(UserGender::class, 'gender_id');
    }

    public function Status() {
        return $this->belongsTo(UserMaritalStatus::class, 'status_id');
    }

    public function Country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function Identity() {
        return $this->belongsTo(UserIdentityType::class, 'identity_id');
    }

    public function Bank() {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

   
}