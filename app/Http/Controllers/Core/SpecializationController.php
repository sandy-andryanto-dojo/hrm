<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Specialization;

class SpecializationController extends MyController{

    public function __construct(){
        $this->model = new Specialization;
        $this->route = "specializations";
        $this->exportTitle = "DAFTAR_JENIS_SPESIALISASI";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_specliationations',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_specliationations,name,' . $id,
        ];
    }

    
}