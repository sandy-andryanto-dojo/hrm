<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Master\Contact;

class ContactController extends MyController{

    public function __construct(){
        $this->model = new Contact;
        $this->route = "contacts";
        $this->exportTitle = "DAFTAR_KONTAK";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:contacts',
            'email' => 'email|unique:contacts',
            'phone' => 'unique:contacts',
            'website' => 'unique:contacts'
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:contacts,name,' . $id,
            'email' => 'email|unique:contacts,email,'.$id,
            'phone' => 'unique:contacts,phone,'.$id,
            'website' => 'unique:contacts,website,'.$id,
        ];
    }

    
}