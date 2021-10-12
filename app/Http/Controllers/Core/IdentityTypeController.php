<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Auth\UserIdentityType;

class IdentityTypeController extends MyController{

    public function __construct(){
        $this->model = new UserIdentityType;
        $this->route = "identity_types";
        $this->exportTitle = "DAFTAR_JENIS_IDENTITAS";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:users_identity_types',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:users_identity_types,name,' . $id,
        ];
    }

    
}