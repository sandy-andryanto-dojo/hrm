<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Core\District;
use App\Models\Core\Province;

class DistrictController extends MyController{

    public function __construct(){
        $this->model = new District;
        $this->route = "districts";
        $this->exportTitle = "DAFTAR_KECAMATAN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191',
            'province_id' => 'required',
            'regency_id' => 'required'
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191',
            'province_id' => 'required',
            'regency_id' => 'required'
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["provinces"] = Province::orderBy("name","ASC")->get();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function edit($id){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
        $items["provinces"] = Province::orderBy("name","ASC")->get();
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }
    
   

   

    
}