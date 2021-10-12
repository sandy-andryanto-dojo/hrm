<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\EmployeeMutation;
use App\Models\Employees\Employee;
use App\Models\Organization\Division;

class EmployeeMutationController extends MyController{

    public function __construct(){
        $this->model = new EmployeeMutation;
        $this->route = "employee_mutations";
        $this->exportTitle = "DAFTAR_MUTASI";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'employee_id' => 'required',
            'division_from_id'=>'required',
            'division_target_id' => 'required',
            'reason' => 'required',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'employee_id' => 'required',
            'division_from_id'=>'required',
            'division_target_id' => 'required',
            'reason' => 'required',
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["divisions"] = Division::orderBy("name","ASC")->get();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    protected function beforeStore(Request $request){
        $division = Division::where("id", $request->get("division_target_id"))->first();
        $employee = Employee::where("user_id", $division->superior_id)->first();
        $request["manager_id"] = $employee->id;
    }

    protected function beforeUpdate(Request $request, $id){
        $division = Division::where("id", $request->get("division_target_id"))->first();
        $employee = Employee::where("user_id", $division->superior_id)->first();
        $request["manager_id"] = $employee->id;
    }

    public function update(Request $request, $id){
       if((int) $id == 0){
            $eid  = $request->get("eid");
            $post = $request->all();
            $data = $this->model->findData($eid);
            $data->is_approved = 1;
            $data->save();

            $employee_id = $data->employee_id;
            $division_id = $data->division_target_id;
            $employee = Employee::where("id", $employee_id)->first();
            $employee->division_id =  $data->division_target_id;
            $employee->save();

            // Approval Notif
            $admin = \Auth::User()->userAdmin();
            foreach($admin as $ad){
                $sender_id = \Auth::User()->id;
                $subject = "Konfirmasi Persetujuan Permohonan Mutasi Pegawai";
                $link = route($this->route.".index");
                \App\Helpers\AppHelper::sendNotif([
                    "sender_id"=>$sender_id,
                    "recevier_id"=>$ad,
                    "subject"=>$subject,
                    "message"=>"Proses mutasi berhasil dikonfirmasi",
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
        $items["divisions"] = Division::orderBy("name","ASC")->get();
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }

    protected function afterStore(Request $request, $data){
        // Approval Submission
        $id = $data->id;
        $employee = Employee::where("id", $request->get("employee_id"))->first();
        $division = Division::where("id", $request->get("division_target_id"))->first();
        $sender_id = \Auth::User()->id;
        $recevier_id = $division->superior_id;
        $subject = "Permohonan Mutasi Pegawai";
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