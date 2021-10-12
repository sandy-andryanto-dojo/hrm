<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Core\Setting;

class CompanyController extends MyController{

    public function __construct(){
        $this->model = new Setting;
        $this->route = "companies";
        $this->useCode = false;
    }

    public function index(){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        return view('core.'.$this->route.'.index', $items);
	}

    public function store(Request $request){

        $rules = [
            'nama-perusahaan' => 'profanity',
            'npwp-perusahaan' => 'profanity',
            'kodepos-perusahaan' => 'profanity',
            'email-perusahaan' => 'profanity',
            'telepon-perusahaan' => 'profanity',
            'alamat-perusahaan' => 'profanity',
            'provinsi-perusahaan' => 'profanity',
            'kota-perusahaan' => 'profanity',
            'kecamatan-perusahaan' => 'profanity',
            'kelurahan-perusahaan' => 'profanity',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $post = $request->all();
            $this->model->CreateAndUpdate($post);
            return redirect()->route($this->route.'.index')->with('success', 'Profil perusahaan berhasil diubah.');
        }
    }

    public function create(){
        return abort(404);    
    }

    public function show($id){
        return abort(404);   
    }

    public function edit($id){
        return abort(404);   
    }

    public function update(Request $request, $id){
        return abort(404);  
    }

    public function destroy($id){
        return abort(404);   
    }
    
}