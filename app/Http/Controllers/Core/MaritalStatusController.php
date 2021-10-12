<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Auth\UserMaritalStatus;

class MaritalStatusController extends MyController{

    public function __construct(){
        $this->model = new UserMaritalStatus;
        $this->route = "marital_status";
        $this->exportTitle = "DAFTAR_STATUS_NIKAH";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:users_marital_status',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:users_marital_status,name,' . $id,
        ];
    }

    
}