<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeAllowance;
use App\Models\Master\AllowanceType;

class EmployeeAllowanceController extends MyController{

    public function __construct(){
        $this->model = new Employee;
        $this->route = "employee_allowances";
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
        $items["allowances_employee"] = EmployeeAllowance::where("employee_id", $id)->get();
        $items["allowances_type"] = AllowanceType::orderBy("name", "ASC")->get();
		$config = $this->onShow($items);
		return view('core.'.$this->route.'.show', $config);
    }

    public function update(Request $request, $id){
        if($request->get("type_id")){
            EmployeeAllowance::where("employee_id", $id)->delete();
            $types = $request->get("type_id");
            $cost = $request->get("cost");
            $i = 0;
            foreach($types as $type){
                $val_cost = isset($cost[$i]) ? \App\Helpers\AppHelper::truncateFormatNumber($cost[$i])  : 0;
                $is_active = (int) $val_cost > 0 ? 1 : 0;
                EmployeeAllowance::create([
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
        
        $types = AllowanceType::orderBy("name", "ASC")->get();
        $allowances = array();
        foreach($types as $type){
            $temp = EmployeeAllowance::where("employee_id", $id)->where("type_id", $type->id)->first();
            $allowances[] = array(
                "name"=>$type->name,
                "employee_id"=>$id,
                "type_id"=>$type->id,
                "cost"=> $temp ? $temp->cost : 0,
                "is_active"=> $temp ? $temp->is_active : 0
            );
        }
        $items["allowances"] = $allowances;
        $items["is_edit"] = EmployeeAllowance::where("employee_id", $id)->count() > 0 ? true : false;

		$config = $this->onEdit($items);
		return view('core.'.$this->route.'.edit', $config);
    }
    
}