<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\EmployeeAnnual;
use App\Models\Master\AnnualType;

class EmployeeAnnualController extends MyController{

    public function __construct(){
        $this->model = new EmployeeAnnual;
        $this->route = "employee_annuals";
        $this->exportTitle = "DAFTAR_PERMOHONAN_CUTI";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'type_id'=>'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'type_id'=>'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'reason' => 'required',
        ];
    }

    public function index(){
        $employee_id = \Auth::User()->getEmployeeId();
        $manager_id = \Auth::User()->getManagerId();
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["employee_id"] = $employee_id;
        $items["manager_id"] = $manager_id;
        $items["pending"] = $this->model->where("employee_annual.manager_id", $employee_id)->where("is_approved", 0)->count();
        return view('core.'.$this->route.'.index', $items);
	}

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["types"] = AnnualType::orderBy("name", "ASC")->get();
        $items["employee_id"] = \Auth::User()->getEmployeeId();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function edit($id){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
        $items["types"] = AnnualType::orderBy("name", "ASC")->get();
        $items["employee_id"] = \Auth::User()->getEmployeeId();
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }

    public function show($id){
		if((int)$id == 0){
            $this->model->setEmployeeId(\Auth::User()->getEmployeeId());
            $this->model->setMode(0);
            return $this->download();
        }else{
            $items = array();
            $items["metaPermission"] = $this->metaPermission();
            $items["data"] = $this->model->findData($id);
            $items["form"] = ["method"=>"DELETE", "route"=>[$this->route.'.destroy',  $id]];
            $items["employee_id"] = \Auth::User()->getEmployeeId();
            $config = $this->onShow($items);
            return view('core.'.$this->route.'.show', $config);
        }
	}
    
    protected function beforeStore(Request $request){
        $employee = \Auth::User()->getEmployee();
        $request["employee_id"] = $employee->id;
        $request["manager_id"] = $employee->Division && $employee->Division->getEmployee ? $employee->Division->getEmployee->id : null;
        $request["request_date"] = date("Y-m-d");
    }

    public function update(Request $request, $id){
        if((int) $id == 0){
            // Approval
            $post = $request->all();
            $approved = (int) $request->get("is_approved");
            $eid = $request->get("eid");
            $data = $this->model->findData($eid);
            $data->manager_notes = $request->get("manager_notes");
            $data->is_approved = $request->get("is_approved");
            $data->save();
            $status = \App\Helpers\AppHelper::getAnnualStatus($approved, true);

            $message = "Persetujuan cuti berhasil diperbaharui dengan status <strong>".$status."</strong>";

            // Approval Notif
            $sender_id = \Auth::User()->id;
            $recevier_id = $data->Employee->user_id;
            $jenisCuti = AnnualType::findOrfail($data->type_id);
            $subject = "Konfirmasi Persetujuan Permohonan ".$jenisCuti->name;
            $link = route($this->route.".show", ["id"=>$eid]);
            \App\Helpers\AppHelper::sendNotif([
                "sender_id"=>$sender_id,
                "recevier_id"=>$recevier_id,
                "subject"=>$subject,
                "message"=>$message,
                "link"=>$link
            ]);

            return redirect()->route($this->route.".show", ["id"=>$eid])->with('success', $message);
        }else{
            // Update Biasa
            $rules = $this->updateValidation($id);
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $this->beforeUpdate($request, $id);
                $post = $request->all();
                $data = $this->model->findData($id);
                $data->fill($post);
                $data->save();
                $this->afterUpdate($request, $data);
                return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPATED);
            }
        }
	}

    protected function afterStore(Request $request, $data){
        // Approval Submission
        $id = $data->id;
        $employee = \Auth::User()->getEmployee();
        $sender_id = \Auth::User()->id;
        $recevier_id = $employee->Division->superior_id ? $employee->Division->superior_id : null;
        $jenisCuti = AnnualType::findOrfail($request->get("type_id"));
        $subject = "Permohonan ".$jenisCuti->name;
        $message = $request->get("reason");
        $link = route($this->route.".show", ["id"=>$id]);
        \App\Helpers\AppHelper::sendNotif([
            "sender_id"=>$sender_id,
            "recevier_id"=>$recevier_id,
            "subject"=>$subject,
            "message"=>$message,
            "link"=>$link
        ]);
    }
    
}