<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\EmployeeRetired;
use App\Models\Employees\Employee;

class EmployeeRetiredController extends MyController{

    public function __construct(){
        $this->model = new EmployeeRetired;
        $this->route = "employee_retireds";
        $this->exportTitle = "DAFTAR_PENSIUN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'employee_id' => 'required|unique:employee_retired',
            'date_retired'=>'required',
            'reason' => 'required',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'employee_id' => 'required|unique:employee_retired,employee_id,' . $id,
            'date_retired'=>'required',
            'reason' => 'required',
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    protected function beforeStore(Request $request){
       $employee = Employee::where("id", $request->get("employee_id"))->first();
       $user_manager_id = $employee->Division->Superior->user_id; 
       $manager = Employee::where("user_id", $user_manager_id)->first();
       $request["manager_id"] = $manager->id;
    }

    protected function beforeUpdate(Request $request, $id){
        $employee = Employee::where("id", $request->get("employee_id"))->first();
        $user_manager_id = $employee->Division->Superior->user_id; 
        $manager = Employee::where("user_id", $user_manager_id)->first();
        $request["manager_id"] = $manager->id;
    }

    public function update(Request $request, $id){
       if((int) $id == 0){
            $eid  = $request->get("eid");
            $post = $request->all();
            $data = $this->model->findData($eid);
            $data->is_approved = 1;
            $data->save();

            // Approval Notif
            $admin = \Auth::User()->userAdmin();
            foreach($admin as $ad){
                $sender_id = \Auth::User()->id;
                $subject = "Konfirmasi Persetujuan Permohonan Pensiun Pegawai";
                $link = route($this->route.".index");
                \App\Helpers\AppHelper::sendNotif([
                    "sender_id"=>$sender_id,
                    "recevier_id"=>$ad,
                    "subject"=>$subject,
                    "message"=>"Proses Pensiun berhasil dikonfirmasi",
                    "link"=>$link
                ]);
            }

            return redirect()->route($this->route.".index")->with('success', "Mutasi pegawai berhasil disetujui");
       }else{
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

    public function edit($id){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }

    protected function afterStore(Request $request, $data){
        // Approval Submission
        $id = $data->id;
        $employee = Employee::where("id", $request->get("employee_id"))->first();
        $sender_id = \Auth::User()->id;
        $recevier_id = $employee->Division->superior_id ? $employee->Division->superior_id : null;
        $subject = "Permohonan Pensiun Pegawai";
        $message = $request->get("reason");
        $link = route($this->route.".index");
        \App\Helpers\AppHelper::sendNotif([
            "sender_id"=>$sender_id,
            "recevier_id"=>$recevier_id,
            "subject"=>$subject,
            "message"=>$message,
            "link"=>$link
        ]);
    }

    
}