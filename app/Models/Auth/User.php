<?php

namespace App\Models\Auth;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Tymon\JWTAuth\Contracts\JWTSubject;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Support\Arr;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Auth\UserProfile;
use App\Models\Auth\UserConfirm;
use App\Notifications\PasswordReset;
use App\Models\Employees\Employee;
use App\Models\Core\Message;


class User extends Authenticatable  implements JWTSubject, Auditable
{
    use Notifiable, SoftDeletes, HasRoles, \OwenIt\Auditing\Auditable;

    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 
        'email', 
        'phone', 
        'password',
        'email_confirm', 
        'phone_confirm', 
        'is_root',
        'session_id',
        'access_groups'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function transformAudit(array $data): array {
        if (Arr::has($data, 'new_values.role_id')) {
            $data['old_values']['role_name'] = Role::find($this->getOriginal('role_id'))->name;
            $data['new_values']['role_name'] = Role::find($this->getAttribute('role_id'))->name;
        }

        return $data;
    }

    public function UserProfile() {
        return $this->hasOne(UserProfile::class);
    }

    public function UserConfirm() {
        return $this->hasOne(UserConfirm::class);
    }

    public function sendPasswordResetNotification($token) {
        $this->notify(new PasswordReset($token));
    }

    public function Employee() {
        return $this->hasMany(Employee::class);
    }

    public function Message() {
        return $this->hasMany(Message::class);
    }

    public function getEmployee(){
        if(\Auth::check()){
            $user_id = \Auth::User()->id;
            $employee = Employee::where("user_id", $user_id)->first();
            return !is_null($employee) ? $employee : null;
        }
        return null;
    }

    public function getEmployeeId(){
        if(\Auth::check()){
            $user_id = \Auth::User()->id;
            $employee = Employee::where("user_id", $user_id)->first();
            return !is_null($employee) ? $employee->id : null;
        }
        return null;
    }

    public function getManagerId(){
        if(\Auth::check()){
            $user_id = \Auth::User()->id;
            $employee = Employee::where("user_id", $user_id)->first();
            if(isset($employee->Division) && isset($employee->Division->Superior)){
                $uid = $employee->Division->Superior->user_id;
                if(!is_null($uid)){
                    $em = Employee::where("user_id", $uid)->first();
                    return !is_null($em) ? $em->id : null;
                }
            }
        }
        return null;
    }

    public function isAdmin(){
        if(\Auth::check()){
            $user = \Auth::User();
            $roles = $user->Roles()->get()->pluck("name")->toArray();
            return in_array("Admin", $roles) ? true : false;
        }
        return false;
    }

    public function userAdmin(){
        return self::distinct("users.id")
            ->join("model_has_roles","model_has_roles.model_id","=","users.id")
            ->join("roles","roles.id","=","model_has_roles.role_id")
            ->where("roles.name", "Admin")
            ->pluck("users.id")
            ->toArray();
    }
}
