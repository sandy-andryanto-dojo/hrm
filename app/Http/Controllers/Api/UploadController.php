<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\AppController;
use App\Utils\CropImage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Core\Setting;
use App\Models\Core\Attachment;

class UploadController extends AppController{

    public function profileImage(Request $request){
        $id = \Auth::User()->id;
        $profile = Attachment::getByModel("App\Models\Auth\User", $id);
        $avatarSrc = isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null;
        $avatarData = isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null;
        $avatarFile = isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null;
        $crop = new CropImage($avatarSrc, $avatarData, $avatarFile);
        $result = str_replace(public_path(), NULL, $crop->getResult());
        $realPhoto = $result;
        $arr_photo = explode('/', $result);
        if (!is_dir(public_path() . "/uploads/users/")) {
            mkdir(public_path() . "/uploads/users/");
        }

        $photo = 'uploads/users/' . end($arr_photo);
        $copy = copy(public_path() . '/' . $result, public_path() . '/' . $photo);

        if ($copy) {
            if (!is_null($profile)) {
                if (file_exists($profile->path)) {
                    unlink(public_path() . '/' . $profile->path);
                }
                $profile->path = $photo;   
                $profile->type = mime_content_type(public_path() . '/' . $photo);
                $profile->size = filesize(public_path() . '/' . $photo);
                $profile->save();
                $realPhoto = $photo;
            }else{
                $input = [
                    'is_folder'=>0,
                    'name'=>'Profile Image',
                    'path'=>$photo,
                    'type'=>mime_content_type(public_path() . '/' . $photo),
                    'size'=>filesize(public_path() . '/' . $photo),
                    'parent_id'=> null,
                    'model_id'=> $id,
                    'model_name'=>'App\Models\Auth\User'
                ];
                Attachment::create($input);
                $realPhoto = $photo;
            }

            if ($crop->getOriginal()) {
                $original = str_replace(public_path(), NULL, $crop->getOriginal());
                if (file_exists(public_path() . '/' . $original)) {
                    unlink(public_path() . '/' . $original);
                }
            }
            unlink(public_path() . '/' . $result);
        }

        $response = array(
            'state' => 200,
            'message' => $crop->getMsg(),
            'result' => url($realPhoto)
        );

        return response()->json($response);
    }

    public function temp(Request $request){
        $result = array();
        if (!is_dir(public_path() . "/uploads/temp/")) {
            mkdir(public_path() . "/uploads/temp/");
        }
        $file = $request->file('file');
        $filename = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $ext = $file->getClientOriginalExtension();
        $token = \App\Helpers\AppHelper::genToken();
        $newName = strtolower($token).".".$ext;
        $moved = $file->move('uploads/temp',$newName);
        if($moved){
            return response()->json(["uploads/temp/".$newName]);
        }else{
            return response()->json(false);
        }
    }

    public function companyImage(Request $request){
       
        $logo = Setting::where("setting_slug", "logo-perusahaan")->first();
        
        if(!is_null($logo)){
            if(file_exists($logo->setting_value)){
                unlink($logo->setting_value);
            }
        }

        $avatarSrc = isset($_POST['avatar_src']) ? $_POST['avatar_src'] : null;
        $avatarData = isset($_POST['avatar_data']) ? $_POST['avatar_data'] : null;
        $avatarFile = isset($_FILES['avatar_file']) ? $_FILES['avatar_file'] : null;
        $crop = new CropImage($avatarSrc, $avatarData, $avatarFile);
        $result = str_replace(public_path(), NULL, $crop->getResult());
        $realPhoto = $result;
        $arr_photo = explode('/', $result);
        if (!is_dir(public_path() . "/uploads/")) {
            mkdir(public_path() . "/uploads/");
        }

        $photo = 'uploads/' . end($arr_photo);
        $copy = copy(public_path() . '/' . $result, public_path() . '/' . $photo);

        if ($copy) {

            $logo->setting_value = $photo;
            $logo->save();

            if ($crop->getOriginal()) {
                $original = str_replace(public_path(), NULL, $crop->getOriginal());
                if (file_exists(public_path() . '/' . $original)) {
                    unlink(public_path() . '/' . $original);
                }
            }

            $realPhoto = $photo;

            unlink(public_path() . '/' . $result);

        }

        $response = array(
            'state' => 200,
            'message' => $crop->getMsg(),
            'result' => url($realPhoto)
        );

        return response()->json($response);
    
    }
    
}