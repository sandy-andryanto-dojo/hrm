<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Industries;

class IndustryController extends MyController{

    public function __construct(){
        $this->model = new Industries;
        $this->route = "industries";
        $this->exportTitle = "DAFTAR_JENIS_INDUSTRI";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_industries',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_industries,name,' . $id,
        ];
    }

    
}