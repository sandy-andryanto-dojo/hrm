<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Bank;
use App\Models\Core\Country;

class BankController extends MyController{

    public function __construct(){
        $this->model = new Bank;
        $this->route = "banks";
        $this->exportTitle = "DAFTAR_BANK";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:banks',
            'country_id' => 'required'
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:banks,name,' . $id,
            'country_id' => 'required'
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["countries"] = Country::orderBy("name", "ASC")->get();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function edit($id){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
        $items["metaPermission"] = $this->metaPermission();
        $items["countries"] = Country::orderBy("name", "ASC")->get();
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }
    
   

   

    
}