<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\AllowanceType;

class AllowanceTypeController extends MyController{

    public function __construct(){
        $this->model = new AllowanceType;
        $this->route = "allowance_types";
        $this->exportTitle = "DAFTAR_JENIS_TUNJANGAN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_allowance_type',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_allowance_type,name,' . $id,
        ];
    }

    
}