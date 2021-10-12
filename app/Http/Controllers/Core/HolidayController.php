<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Holiday;

class HolidayController extends MyController{

    public function __construct(){
        $this->model = new Holiday;
        $this->route = "holidays";
        $this->exportTitle = "DAFTAR_HARI_LAIBUR";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'date_holiday' => 'required|unique:holidays'
        ];
	}
    
    protected function updateValidation($id){
		return [
            'date_holiday' => 'required|unique:holidays,date_holiday,'.$id,
        ];
    }

    
}