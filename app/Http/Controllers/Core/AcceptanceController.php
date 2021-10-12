<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Recruitment\Acceptance;
use App\Models\Recruitment\Vacancy;
use App\Models\Master\AttachmentType;
use App\Models\Employees\Employee;
use App\Models\Auth\User;

class AcceptanceController extends MyController{

    private $vacancy;

    public function __construct(){
        $this->model = new Acceptance;
        $this->vacancy = new Vacancy;
        $this->route = "acceptances";
        $this->exportTitle = "";
        $this->useCode = false;
    }

    public function show($id){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->vacancy->findData($id);
        $items["candidates"] = $this->model->where("vacancy_id", $id)->get();
        $items["attachments"] = AttachmentType::orderBy("name","ASC")->get();
		$config = $this->onShow($items);
		return view('core.'.$this->route.'.show', $config);
    }

    public function update(Request $request, $id){
        $eid = $request->get('eid');
        $status = $request->get('status');
        $data = $this->model->findOrFail($eid);
        $vacancy_id = $data->vacancy_id;
        $employeeName = $data->Candidate->first_name." ".$data->Candidate->last_name;
        if((int) $status == 1){
        
            $user = $this->model->storeEmployee($request, $eid);
            $data->manager_approved = 1;
            $data->save();   

            $adminId = User::distinct("users.id")
                ->join("model_has_roles","model_has_roles.model_id","=","users.id")
                ->join("roles","roles.id","=","model_has_roles.role_id")
                ->where("roles.name", "Admin")
                ->pluck("users.id")
                ->toArray();

            // Send Notif
            $emp = Employee::where("user_id", $user->id)->first();
            $vacancy = $this->vacancy->findData($vacancy_id);
            $sender_id = \Auth::User()->id;
            $receveir = User::whereIn("id", $adminId)->get();
            foreach($receveir as $rc){
                $subject = "Penerimaan Pegawai Baru";
                $message = $employeeName." dengan no pegawai ".$emp->employee_number." . sudah diterima.";
                $link = route("workers.show", ["id"=>$emp->id]);
                \App\Helpers\AppHelper::sendNotif([
                    "sender_id"=>$sender_id,
                    "recevier_id"=>$rc->id,
                    "subject"=>$subject,
                    "message"=>$message,
                    "link"=>$link
                ]);
            }

            return redirect()->route($this->route.".show", ["id"=>$vacancy_id])->with('success', "Pegawai baru atas nama ".$employeeName." berhasil bergabung.");
        }else{
            $data->manager_approved = -1;
            $data->save();    
            return redirect()->route($this->route.".show", ["id"=>$vacancy_id])->with('warning', "Pegawai baru atas nama ".$employeeName." sudah ditolak.");
        }
	}
    
    public function edit($id){
        return abort(404);  
    }
    
    public function destroy($id){
        return abort(404);  
    }
    
    public function create(){
        return abort(404);  
	}
    
}