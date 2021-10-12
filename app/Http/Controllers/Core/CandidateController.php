<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Vacancy;
use App\Models\Recruitment\Acceptance;
use App\Models\Core\Country;
use App\Models\Auth\UserBloodType;
use App\Models\Auth\UserGender;
use App\Models\Auth\UserMaritalStatus;
use App\Models\Auth\UserIdentityType;
use App\Models\Master\AttachmentType;
use App\Models\Core\Attachment;
use App\Models\Employees\Employee;

class CandidateController extends MyController{

    public function __construct(){
        $this->model = new Candidate;
        $this->route = "candidates";
        $this->exportTitle = "DAFTAR_KANDIDAT";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            "first_name"=>"required",
            "email"=>"required",
            "phone"=>"required",
            "identity_number"=>"required",
            "birth_date"=>"required",
            "birth_place"=>"required",
            "country_id"=>"required",
            "gender_id"=>"required",
            "status_id"=>"required",
            "blood_id"=>"required",
            "identity_id"=>"required",
            "address"=>"required",
            'vacancies' => 'required|min:1',
        ];
	}
    
    protected function updateValidation($id){
		return [
            "first_name"=>"required",
            "email"=>"required",
            "phone"=>"required",
            "identity_number"=>"required",
            "birth_date"=>"required",
            "birth_place"=>"required",
            "country_id"=>"required",
            "gender_id"=>"required",
            "status_id"=>"required",
            "blood_id"=>"required",
            "identity_id"=>"required",
            "address"=>"required",
            'vacancies' => 'required|min:1',
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["countries"] = Country::orderBy("name", "ASC")->get();
        $items["genders"] = UserGender::orderBy("name","ASC")->get();
        $items["bloods"] = UserBloodType::orderBy("name","ASC")->get();
        $items["maritals"] = UserMaritalStatus::orderBy("name","ASC")->get();
        $items["identities"] = UserIdentityType::orderBy("name","ASC")->get();
        $items["attachments"] = AttachmentType::orderBy("name","ASC")->get();
        $items["vacancies"] = Vacancy::where("is_closed", 0)->orderBy("name","ASC")->get();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function edit($id){
        $items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
        $items["countries"] = Country::orderBy("name", "ASC")->get();
        $items["genders"] = UserGender::orderBy("name","ASC")->get();
        $items["bloods"] = UserBloodType::orderBy("name","ASC")->get();
        $items["maritals"] = UserMaritalStatus::orderBy("name","ASC")->get();
        $items["identities"] = UserIdentityType::orderBy("name","ASC")->get();
        $items["attachments"] = AttachmentType::orderBy("name","ASC")->get();
        $items["vacancySelected"] = Acceptance::where("candidate_id", $id)->get()->pluck("vacancy_id")->toArray();
        $items["vacancies"] = Vacancy::where("is_closed", 0)->orderBy("name","ASC")->get();
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }

    public function show($id){
		if((int)$id == 0) return $this->download();
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
		$items["data"] = $this->model->findData($id);
        $items["form"] = ["method"=>"DELETE", "route"=>[$this->route.'.destroy',  $id]];
        $items["attachments"] = AttachmentType::orderBy("name","ASC")->get();
        $items["vacancies"] = Acceptance::where("candidate_id", $id)->get();
		$config = $this->onShow($items);
		return view('core.'.$this->route.'.show', $config);
	}

    protected function afterStore(Request $request, $data){
        $this->uploadAttachment($request, $data->id);
        $this->syncVacancies($request->get("vacancies"), $data->id);
    }

    protected function afterUpdate(Request $request, $data){
        $this->uploadAttachment($request, $data->id);
        $this->syncVacancies($request->get("vacancies"), $data->id);
    }
    
    private function uploadAttachment(Request $request, $id){
        $group_id = $request->get("group_id");
        if(count($group_id) > 0){
            if($request->hasfile('filename')){
                $fileUpload = $request->file('filename');
                for($i = 0; $i < count($group_id); $i++){
                    if(isset($fileUpload[$i])){
                        $file = $fileUpload[$i];
                        $name = md5(time()."_".str_random(100)).'.'.$file->getClientOriginalExtension();
                        $file->move(public_path().'/uploads/candidates/', $name);  
                        $path = "uploads/candidates/".$name;
                        $fileName = AttachmentType::findOrFail($group_id[$i])->name;
                        $attachment = Attachment::where("model_name", "App\Models\Recruitment\Candidate")->where("model_id", $id)->where("group_id", $group_id[$i])->first();
                        if(!is_null($attachment)){
                            if(file_exists($attachment->path)){
                                unlink($attachment->path);
                            }
                            $attachment->name = $fileName;
                            $attachment->path = $path;
                            $attachment->type = mime_content_type(public_path("uploads/candidates/".$name));
                            $attachment->size = filesize(public_path("uploads/candidates/".$name));
                            $attachment->save();
                        }else{
                            Attachment::create([
                                'is_folder'=>0,
                                'name'=>$fileName,
                                'path'=>$path,
                                'type'=>mime_content_type(public_path("uploads/candidates/".$name)),
                                'size'=>filesize(public_path("uploads/candidates/".$name)),
                                'parent_id'=> null,
                                'group_id'=>$group_id[$i],
                                'model_id'=> $id,
                                'model_name'=>"App\Models\Recruitment\Candidate"
                            ]);
                        }
                    }
                }
            }
        }
    }

    protected function afterDestroy($id){
        Acceptance::where("candidate_id", $id)->delete();
    }

    private function syncVacancies($vacancies, $candidate_id){
        foreach($vacancies as $vac){

            Acceptance::where("candidate_id", $candidate_id)->delete();

            $vacancy = Vacancy::findOrfail($vac);
            $division = $vacancy->Division;
            $superior = $division->Superior->user_id;
            $manager = Employee::where("user_id", $superior)->first();
            $hrd_id = \Auth::User()->getEmployeeId();
            $manager_id = $manager->id;
            Acceptance::create([
                "vacancy_id"=>$vac,
                "candidate_id"=>$candidate_id,
                "hrd_id"=>$hrd_id,
                "manager_id"=>$manager_id,
                "hrd_approved"=>1,
                "manager_approved"=>0,
            ]);

            // Send Notif
            $employee = \Auth::User()->getEmployee();
            $sender_id = \Auth::User()->id;
            $subject = "Calon Pegawai Posisi ".$vacancy->Position->name;
            $message = "Penerimaan pegawai untuk posisi ".$vacancy->Position->name." pada divisi ".$vacancy->Division->name;
            $link = route("acceptances.show", ["id"=>$vac]);
            \App\Helpers\AppHelper::sendNotif([
                "sender_id"=>$sender_id,
                "recevier_id"=>$superior,
                "subject"=>$subject,
                "message"=>$message,
                "link"=>$link
            ]);
                

        }
        
    }

    
}