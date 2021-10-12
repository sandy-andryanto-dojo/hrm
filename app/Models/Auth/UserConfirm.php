<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use App\Models\Auth\User;

class UserConfirm extends Model{

    protected $table = 'users_confirm';
    protected $fillable = [
        'user_id',
        'token'
    ];

    protected $guarded = [];

    public function User() {
        return $this->belongsTo(User::class, 'user_id');
    }

}