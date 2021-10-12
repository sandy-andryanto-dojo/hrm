<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Core\Province;
use App\Models\Core\Country;

class ProvinceController extends MyController{

    public function __construct(){
        $this->model = new Province;
        $this->route = "provinces";
        $this->exportTitle = "DAFTAR_PROVINSI";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:provinces',
            'country_id' => 'required'
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:provinces,name,' . $id,
            'country_id' => 'required'
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["country_id"] = Country::where("iso_code","ID")->first()->id;
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function edit($id){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
        $items["metaPermission"] = $this->metaPermission();
        $items["country_id"] = Country::where("iso_code","ID")->first()->id;
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }
    
   

   

    
}