<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\LossType;

class LossTypeController extends MyController{

    public function __construct(){
        $this->model = new LossType;
        $this->route = "loss_types";
        $this->exportTitle = "DAFTAR_JENIS_POTONGAN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_loss_type',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_loss_type,name,' . $id,
        ];
    }

    
}