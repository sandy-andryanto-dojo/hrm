<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\EmployeePromotion;
use App\Models\Employees\Employee;
use App\Models\Organization\Position;

class EmployeePromotionController extends MyController{

    public function __construct(){
        $this->model = new EmployeePromotion;
        $this->route = "employee_promotions";
        $this->exportTitle = "DAFTAR_KENAIKAN_JABATAN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'employee_id' => 'required',
            'position_target_id' => 'required',
            'reason' => 'required',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'employee_id' => 'required',
            'position_target_id' => 'required',
            'reason' => 'required',
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["positions"] = Position::orderBy("name","ASC")->get();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    protected function beforeStore(Request $request){
       $employee = Employee::where("id", $request->get("employee_id"))->first();
       $user_manager_id = $employee->Division->Superior->user_id; 
       $manager = Employee::where("user_id", $user_manager_id)->first();
       $request["manager_id"] = $manager->id;
       $request["position_from_id"] = $employee->position_id;
    }

    protected function beforeUpdate(Request $request, $id){
        $employee = Employee::where("id", $request->get("employee_id"))->first();
        $user_manager_id = $employee->Division->Superior->user_id; 
        $manager = Employee::where("user_id", $user_manager_id)->first();
        $request["manager_id"] = $manager->id;
        $request["position_from_id"] = $employee->position_id;
    }

    public function update(Request $request, $id){
       if((int) $id == 0){
            $eid  = $request->get("eid");
            $post = $request->all();
            $data = $this->model->findData($eid);
            $data->is_approved = 1;
            $data->save();

            $employee_id = $data->employee_id;
            $position_id = $data->position_target_id;
            $employee = Employee::where("id", $employee_id)->first();
            $employee->position_id =  $position_id;
            $employee->save();

            // Approval Notif
            $admin = \Auth::User()->userAdmin();
            foreach($admin as $ad){
                $sender_id = \Auth::User()->id;
                $subject = "Konfirmasi Persetujuan Permohonan Promosi Pegawai";
                $link = route($this->route.".index");
                \App\Helpers\AppHelper::sendNotif([
                    "sender_id"=>$sender_id,
                    "recevier_id"=>$ad,
                    "subject"=>$subject,
                    "message"=>"Proses Promosi berhasil dikonfirmasi",
                    "link"=>$link
                ]);
            }

            return redirect()->route($this->route.".index")->with('success', "Kenaikan jabatan pegawai berhasil disetujui");
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
        $items["positions"] = Position::orderBy("name","ASC")->get();
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }

    protected function afterStore(Request $request, $data){
        // Approval Submission
        $id = $data->id;
        $employee = Employee::where("id", $request->get("employee_id"))->first();
        $sender_id = \Auth::User()->id;
        $recevier_id = $employee->Division->superior_id ? $employee->Division->superior_id : null;
        $subject = "Permohonan Promosi Pegawai";
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