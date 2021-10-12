<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Core\Message;

class NotificationController extends MyController{

    public function __construct(){
        $this->model = new Message;
        $this->route = "notifications";
        $this->exportTitle = "DAFTAR_PEMBERITAHUAN";
        $this->useCode = false;
    }

    public function show($id){
        $this->model->where("id", $id)->update(["is_read"=>1]);
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
		$items["data"] = $this->model->findData($id);
		$items["form"] = ["method"=>"DELETE", "route"=>[$this->route.'.destroy',  $id]];
		$config = $this->onShow($items);
		return view('core.'.$this->route.'.show', $config);
	}

    public function create(){
		return abort(404);    
    }

    public function edit($id){
        return abort(404);    
    }
    

   
}