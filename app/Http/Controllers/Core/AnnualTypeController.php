<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\AnnualType;

class AnnualTypeController extends MyController{

    public function __construct(){
        $this->model = new AnnualType;
        $this->route = "annual_types";
        $this->exportTitle = "DAFTAR_JENIS_ABSEN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_annual_type',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_annual_type,name,' . $id,
        ];
    }

    
}