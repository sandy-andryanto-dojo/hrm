<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeCut;
use App\Models\Master\LossType;

class EmployeeCutController extends MyController{

    public function __construct(){
        $this->model = new Employee;
        $this->route = "employee_cuts";
        $this->exportTitle = "";
        $this->useCode = false;
    }

    public function create(){
        return abort(404);    
    }

    public function show($id){
        $items = array();
		$items["metaPermission"] = $this->metaPermission();
		$items["data"] = $this->model->findData($id);
        $items["cuts_employee"] = EmployeeCut::where("employee_id", $id)->get();
        $items["cuts_type"] = LossType::orderBy("name", "ASC")->get();
		$config = $this->onShow($items);
		return view('core.'.$this->route.'.show', $config);
    }

    public function update(Request $request, $id){
        if($request->get("type_id")){
            EmployeeCut::where("employee_id", $id)->delete();
            $types = $request->get("type_id");
            $cost = $request->get("cost");
            $i = 0;
            foreach($types as $type){
                $val_cost = isset($cost[$i]) ? \App\Helpers\AppHelper::truncateFormatNumber($cost[$i])  : 0;
                $is_active = (int) $val_cost > 0 ? 1 : 0;
                EmployeeCut::create([
                    'type_id'=>$type,
                    'employee_id'=>$id,
                    'is_active'=>$is_active,
                    'cost'=>$val_cost
                ]);
                $i++;
            }
        }
        return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPATED);
    }

    public function edit($id){
        $items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
        
        $types = LossType::orderBy("name", "ASC")->get();
        $cuts = array();
        foreach($types as $type){
            $temp = EmployeeCut::where("employee_id", $id)->where("type_id", $type->id)->first();
            $cuts[] = array(
                "name"=>$type->name,
                "employee_id"=>$id,
                "type_id"=>$type->id,
                "cost"=> $temp ? $temp->cost : 0,
                "is_active"=> $temp ? $temp->is_active : 0
            );
        }
        $items["cuts"] = $cuts;
        $items["is_edit"] = EmployeeCut::where("employee_id", $id)->count() > 0 ? true : false;

		$config = $this->onEdit($items);
		return view('core.'.$this->route.'.edit', $config);
    }
    
}