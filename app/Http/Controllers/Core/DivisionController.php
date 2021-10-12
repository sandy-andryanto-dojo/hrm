<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Organization\Division;


class DivisionController extends MyController{

    public function __construct(){
        $this->model = new Division;
        $this->route = "divisions";
        $this->exportTitle = "DAFTAR_DIVISI";
        $this->useCode = true;
        $this->codeIndex = "D";
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_divisions',
            'superior_id' => 'required'
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_divisions,name,' . $id,
            'superior_id' => 'required'
        ];
    } 

    
    
}