<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Job;

class JobController extends MyController{

    public function __construct(){
        $this->model = new Job;
        $this->route = "jobs";
        $this->exportTitle = "DAFTAR_JENIS_PEKERJAAN";
        $this->useCode = true;
        $this->codeIndex = "J";
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_jobs',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_jobs,name,' . $id,
        ];
    }

    
}