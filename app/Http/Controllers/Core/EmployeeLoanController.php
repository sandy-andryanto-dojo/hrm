<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\EmployeeLoan;

class EmployeeLoanController extends MyController{

    public function __construct(){
        $this->model = new EmployeeLoan;
        $this->route = "employee_loans";
        $this->exportTitle = "DAFTAR_PERMOHONAN_PINJAMAN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'cost' => 'required',
            'reason' => 'required',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'cost' => 'required',
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
        $items["pending"] = $this->model->where("employee_loan.manager_id", $employee_id)->where("is_approved", 0)->count();
        return view('core.'.$this->route.'.index', $items);
	}

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["employee_id"] = \Auth::User()->getEmployeeId();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function edit($id){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
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
        $request["cost"] = $request["cost"] ? \App\Helpers\AppHelper::truncateFormatNumber($request["cost"])  : 0;
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

            // Approval Notif
            $sender_id = \Auth::User()->id;
            $recevier_id = $data->Employee->user_id;
            $subject = "Konfirmasi Permohonan Pinjaman";
            $link = route($this->route.".show", ["id"=>$eid]);
            \App\Helpers\AppHelper::sendNotif([
                "sender_id"=>$sender_id,
                "recevier_id"=>$recevier_id,
                "subject"=>$subject,
                "message"=>$request->get("manager_notes"),
                "link"=>$link
            ]);

            return redirect()->route($this->route.".show", ["id"=>$eid])->with('success', "Persetujuan peinjaman berhasil diperbaharui dengan status <strong>".$status."</strong>");
        }else{
            // Update Biasa
            $rules = $this->updateValidation($id);
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            } else {
                $this->beforeUpdate($request, $id);
                $post = $request->all();
                $post["cost"] = $post["cost"] ? \App\Helpers\AppHelper::truncateFormatNumber($post["cost"])  : 0;
                $data = $this->model->findData($id);
                $data->fill($post);
                $data->save();
                $this->afterUpdate($request, $data);
                return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPATED);
            }
        }
    }
    
    // Approval Submission
    protected function afterStore(Request $request, $data){
        $id = $data->id;
        $employee = \Auth::User()->getEmployee();
        $sender_id = \Auth::User()->id;
        $recevier_id = $employee->Division->superior_id ? $employee->Division->superior_id : null;
        $subject = "Permohonan Pinjaman Dana";
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