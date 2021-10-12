<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model{

    protected $table = 'settings';
    protected $fillable = [
        'setting_name',
        'setting_slug',
        'setting_value',
        'setting_group',
        'setting_type'
    ];

    public static function CreateAndUpdate(array $data){
        unset($data["_token"]);
        foreach($data as $row => $key){
            $slug = $row;
            $value = $key;
            $setting = self::where("setting_slug", $slug)->first();
            if(!is_null($setting)){
                $setting->setting_value = $key;
                $setting->save();
            }
        }
    }

    public static function getBySlug($slug){
        $result = self::where("setting_slug", $slug)->first();
        if(!is_null($result)){
            return $result->setting_value;
        }else{
            return $slug;
        }
    }

   
    public static function CompanyProfileSeed(){
        $result = array();
        $items = array(
            array(
                "setting_name"=>"Nama Perusahaan",
                "setting_slug"=>"nama-perusahaan",
                "setting_value"=>"Perusahaan ".time(),
            ),
            array(
                "setting_name"=>"NPWP",
                "setting_slug"=>"npwp-perusahaan",
                "setting_value"=>rand(100000,999999)."".rand(100000,999999),
            ),
            array(
                "setting_name"=>"Kode Pos",
                "setting_slug"=>"kodepos-perusahaan",
                "setting_value"=>rand(1000,9999),
            ),
            array(
                "setting_name"=>"Email",
                "setting_slug"=>"email-perusahaan",
                "setting_value"=>"company@email.com",
            ),
            array(
                "setting_name"=>"Telepon",
                "setting_slug"=>"telepon-perusahaan",
                "setting_value"=>rand(100000,999999)."".rand(100000,999999),
                "setting_group"=>"",
                "setting_type"=>"",
            ),
            array(
                "setting_name"=>"Alamat",
                "setting_slug"=>"alamat-perusahaan",
                "setting_value"=>"Jalan Asia Afrika No : 689",
            ),
            array(
                "setting_name"=>"Provinsi",
                "setting_slug"=>"provinsi-perusahaan",
                "setting_value"=>"Jawa Barat",
            ),
            array(
                "setting_name"=>"Kota",
                "setting_slug"=>"kota-perusahaan",
                "setting_value"=>"Bandung",
                "setting_group"=>"",
                "setting_type"=>"",
            ),
            array(
                "setting_name"=>"kecamatan",
                "setting_slug"=>"kecamatan-perusahaan",
                "setting_value"=>"Sumur Bandung",
            ),
            array(
                "setting_name"=>"Kelurahan",
                "setting_slug"=>"kelurahan-perusahaan",
                "setting_value"=>"Kebon Pisang",
            ),
            array(
                "setting_name"=>"Logo",
                "setting_slug"=>"logo-perusahaan",
                "setting_value"=>"",
            ),
            array(
                "setting_name"=>"Diskon Penjualan",
                "setting_slug"=>"diskon-penjualan",
                "setting_value"=> 0,
            ),
            array(
                "setting_name"=>"Pajak Penjualan",
                "setting_slug"=>"pajak-penjualan",
                "setting_value"=> 0,
            ),
        );

        foreach($items as $row){
            $result[] = self::create([
                'setting_name'=>$row["setting_name"],
                'setting_slug'=>$row["setting_slug"],
                'setting_value'=>$row["setting_value"],
                'setting_group'=>0,
                'setting_type'=>0
            ]);
        }

        return $result;
    }
}