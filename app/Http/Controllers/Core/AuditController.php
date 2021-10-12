<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Auth\Audit;

class AuditController extends MyController{

    public function __construct(){
        $this->model = new Audit;
        $this->route = "audits";
        $this->exportTitle = "DAFTAR_AUDIT_TRAIL";
        $this->useCode = false;
    }

    public function index(){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        return view('core.'.$this->route.'.index', $items);
	}

    public function create(){
        return abort(404);    
    }

    public function show($id){
        return abort(404);   
    }

    public function edit($id){
        return abort(404);   
    }

    public function store(Request $request){
        return abort(404);  
    }

    public function update(Request $request, $id){
        return abort(404);  
    }

    public function destroy($id){
        return abort(404);   
    }
    
}