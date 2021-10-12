<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\AttachmentType;

class AttachmentTypeController extends MyController{

    public function __construct(){
        $this->model = new AttachmentType;
        $this->route = "attachment_types";
        $this->exportTitle = "DAFTAR_JENIS_LAMPIRAN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_attachemt_type',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_attachemt_type,name,' . $id,
        ];
    }

    protected function beforeStore(Request $request){
        $request["is_required"] = $request->get("is_required") ? 1 : 0;
    }

    protected function beforeUpdate(Request $request, $id){
        $request["is_required"] = $request->get("is_required") ? 1 : 0;
    }

    
}