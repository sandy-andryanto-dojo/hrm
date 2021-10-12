<?php

namespace App\Helpers;

use Illuminate\Http\Request;

class AppHelper {

    public static function isEquals($text1, $text2){
        $_text1 = \App\Helpers\AppHelper::truncateString($text1);
        $_text2 = \App\Helpers\AppHelper::truncateString($text2);
        return $_text1 == $_text2 ? true : false;
    }

    public static function truncateString($text){
        $result1 = trim($text);
        $result2 = str_replace(" ", null, $result1);
        return strtolower($result2);
    }

    public static function indonesiaDays($text){
        $days = [
            "monday"=>"Senin",
            "tuesday"=>"Selasa",
            "wednesday"=>"Rabu",
            "thursday"=>"Kamis",
            "friday"=>"Jumat",
            "saturday"=>"Sabtu",
            "sunday"=>"Minggu",
        ];
        return isset($days[$text]) ? $days[$text] : "-";
    }

    public static function getAnnualStatus($status, $textOnly = false){
        $items = array();
        switch((int) $status){
            case 0 : $items = array("label"=>"warning", "text"=>"Menunggu Persetujuan"); break;
            case 1 : $items = array("label"=>"success", "text"=>"Sudah disetujui"); break;
            case 2 : $items = array("label"=>"danger", "text"=>"Di Tolak"); break;
            default: $items = array("label"=>"primary", "text"=>"-"); break;
        }
        $label = $items["label"];
        $text = $items["text"];
        if($textOnly == false){
            return '<span class="label label-'.$label.'">'.$text.'</span>';
        }else{
            return $text;
        }
    }

    public static function getFileByGroup($model, $id, $group_id){
        return  \App\Models\Core\Attachment::getByGroup($model, $id, $group_id);
    }

    public static function getSkills($i){
        $skills = \App\Helpers\AppHelper::Skills();
        return isset($skills[$i]) ? $skills[$i] : "Tidak Ada";
    }

    public static function Skills(){
        return [
            "Pemula",
            "Menengah",
            "Mahir",
            "Sangat Mahir"
        ];
    }

    public static function getMonth($i){
        $months = \App\Helpers\AppHelper::Months();
        return isset($months[$i]) ? $months[$i] : "Tidak Ada";
    }

    public static function Months(){
        return [
            "1"=>"Januari",
            "2"=>"Februari",
            "3"=>"Maret",
            "4"=>"April",
            "5"=>"Mei",
            "6"=>"Juni",
            "7"=>"Juli",
            "8"=>"Agustus",
            "9"=>"September",
            "10"=>"Oktober",
            "11"=>"November",
            "12"=>"Desember"
        ];
    }

    public static function isDemo(){
        if(getenv('APP_DEMO')){
            if(env('APP_DEMO')==TRUE){
                return abort(212);    
            }
        }
    }

    public static function truncateFormatNumber($num){
        $comma = explode(",",$num);
        if(is_null($comma)){
            return (float) str_replace(".", null, $num);
        }else if(isset($comma[0])){
            return (float) str_replace(".", null, $comma[0]);
        }else{
            return 0;
        }
    }


    public static function statusText($label, $text){
        return '<span class="label label-'.$label.'">'.$text.'</span>';
    }

    public static function indexToNumber($val, $digit){
        $i_number = strlen($val);
        $digit = $digit;
        for($i=$digit;$i>$i_number;$i--){
          $val = "0".$val;
        }
        return $val;
    }

    public static function connectedInternet($sCheckHost = 'www.google.com'){
        return (bool) @fsockopen($sCheckHost, 80, $iErrno, $sErrStr, 5);
    }

    public static function genUUID(){
        return 
            sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff), 
            mt_rand(0, 0xffff), 
            mt_rand(0, 0x0fff) | 0x4000, 
            mt_rand(0, 0x3fff) | 0x8000, 
            mt_rand(0, 0xffff), 
            mt_rand(0, 0xffff),
            mt_rand(0, 0xffff)
        );
   }

   public static function genToken(){
        return base64_encode(self::genUUID() . '' . date("Y-m-d H:i:s") . '' . time());
   }

   public static function toSentence($word){
        $result = array();
        $words = explode("_", $word);
        if(count($words) > 0){
            foreach($words as $w){
                $result[] = ucfirst(strtolower($w));
            }
            return implode(" ",$result);
        }else{
            return ucfirst(strtolower($word));
        }
    }

    public static function getSetting($slug){
        return \App\Models\Core\Setting::getBySlug($slug);
    }

    public static function getFile($model, $id){
        return \App\Models\Core\Attachment::getByModel($model, $id);
    }

    public static function uploadFile(Request $request, $model_name, $model_id){
        if($request->file('file')){

            $file = $request->file('file');
            $fileName = str_random(20).'.'.$file->getClientOriginalExtension();
            $destinationPath = public_path('/uploads');
            $file->move($destinationPath, $fileName);

            $attachment = \App\Models\Core\Attachment::where("model_name", $model_name)->where("model_id", $model_id)->first();
            if(!is_null($attachment)){
                if(file_exists($attachment->path)){
                    unlink($attachment->path);
                }
                $attachment->name = $fileName;
                $attachment->path = "uploads/".$fileName;
                $attachment->type = mime_content_type(public_path("uploads/".$fileName));
                $attachment->size = filesize(public_path("uploads/".$fileName));
                $attachment->save();
            }else{
                \App\Models\Core\Attachment::create([
                    'is_folder'=>0,
                    'name'=>$fileName,
                    'path'=>"uploads/".$fileName,
                    'type'=>mime_content_type(public_path("uploads/".$fileName)),
                    'size'=>filesize(public_path("uploads/".$fileName)),
                    'parent_id'=> null,
                    'model_id'=> $model_id,
                    'model_name'=>$model_name
                ]);
            }

            return "uploads/".$fileName;
        }
        return null;
    }

    public static function textUcFirst($text){
        $names = explode(" ",strtolower($text));
        $result = array();
        foreach($names as $name){
            $result[] = ucfirst($name);
        }
        return implode(" ",$result);
    }

    public static function sendNotif(array $options){
        $sender_id = isset($options["sender_id"]) ? $options["sender_id"] : \Auth::User()->id;
        $recevier_id = isset($options["recevier_id"]) ? $options["recevier_id"] : \Auth::User()->id;
        $subject =  isset($options["subject"]) ? $options["subject"] : "No Subject";
        $message =  isset($options["message"]) ? $options["message"] : "No Message";
        $link =  isset($options["link"]) ? $options["link"] : "javascript:void(0);";
        return \App\Models\Core\Message::SendNotif($sender_id, $recevier_id, $subject , $message, $link);
    }

    public static function penyebut($nilai) {
		$nilai = abs($nilai);
		$huruf = array("", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas");
		$temp = "";
		if ($nilai < 12) {
			$temp = " ". $huruf[$nilai];
		} else if ($nilai <20) {
			$temp = \App\Helpers\AppHelper::penyebut($nilai - 10). " belas";
		} else if ($nilai < 100) {
			$temp = \App\Helpers\AppHelper::penyebut($nilai/10)." puluh". \App\Helpers\AppHelper::penyebut($nilai % 10);
		} else if ($nilai < 200) {
			$temp = " seratus" . \App\Helpers\AppHelper::penyebut($nilai - 100);
		} else if ($nilai < 1000) {
			$temp = \App\Helpers\AppHelper::penyebut($nilai/100) . " ratus" . \App\Helpers\AppHelper::penyebut($nilai % 100);
		} else if ($nilai < 2000) {
			$temp = " seribu" . \App\Helpers\AppHelper::penyebut($nilai - 1000);
		} else if ($nilai < 1000000) {
			$temp = \App\Helpers\AppHelper::penyebut($nilai/1000) . " ribu" . \App\Helpers\AppHelper::penyebut($nilai % 1000);
		} else if ($nilai < 1000000000) {
			$temp = \App\Helpers\AppHelper::penyebut($nilai/1000000) . " juta" . \App\Helpers\AppHelper::penyebut($nilai % 1000000);
		} else if ($nilai < 1000000000000) {
			$temp = \App\Helpers\AppHelper::enyebut($nilai/1000000000) . " milyar" . \App\Helpers\AppHelper::penyebut(fmod($nilai,1000000000));
		} else if ($nilai < 1000000000000000) {
			$temp = \App\Helpers\AppHelper::penyebut($nilai/1000000000000) . " trilyun" . \App\Helpers\AppHelper::penyebut(fmod($nilai,1000000000000));
		}     
		return $temp;
	}
 
	public static function terbilang($nilai) {
		if($nilai<0) {
			$hasil = "minus ". trim(\App\Helpers\AppHelper::penyebut($nilai));
		} else {
			$hasil = trim(\App\Helpers\AppHelper::penyebut($nilai));
		}     		
		return $hasil;
	}
}