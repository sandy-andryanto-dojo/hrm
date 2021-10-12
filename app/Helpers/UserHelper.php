<?php

namespace App\Helpers;

use Carbon\Carbon;
use Illuminate\Support\Facades\Route;

class UserHelper {

    public static function accessGroups(array $role_id){
        $roles = \App\Models\Core\Group::whereIn("id", $role_id)->get()->pluck("name")->toArray();
        return count($roles) > 0 ? implode(",",$roles) : null;
    }

    public static function getEmployeePosition(){
        $employee = \Auth::User()->getEmployee();
        return $employee->Position ? \App\Helpers\AppHelper::textUcFirst($employee->Position->name) : "";
    }

    public static function getEmployeeDivision(){
        $employee = \Auth::User()->getEmployee();
        return $employee->Division ? \App\Helpers\AppHelper::textUcFirst($employee->Division->name) : "";
    }

    public static function getRealName($user_id = null){
        $user = is_null($user_id) ? \Auth::User() : \App\Models\Auth\User::find($user_id);
        $profile = $user->UserProfile;
        if(!is_null($profile->first_name) || !is_null($profile->last_name)){
            $result = array();
            if(!is_null($profile->first_name)) $result[] = $profile->first_name;
            if(!is_null($profile->last_name))  $result[] = $profile->last_name;
            return implode(" ",$result);
        }else{
            return $user->username;
        }
    }

    public static function getProfileImage($user_id = null){
        $id = is_null($user_id) ? \Auth::User()->id : $user_id;
        $file = \App\Models\Core\Attachment::getByModel("App\Models\Auth\User", $id);
        $path = is_null($file) ? "assets/core/images/no-user.png" : $file->path;
        return url($path);
    }

    public static function getCompanyLogo(){
        $setting = \App\Models\Core\Setting::where("setting_slug", "logo-perusahaan")->first();
        if(!is_null($setting)){
            if(file_exists($setting->setting_value)){
                return url($setting->setting_value);
            }
        }
        return url("assets/core/images/no-image.png");
    }

    
}