<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeExperience;
use App\Models\Employees\EmployeeEducation;
use App\Models\Employees\EmployeeSpecialist;
use App\Models\Employees\EmployeeToefl;
use App\Models\Organization\Division;
use App\Models\Organization\Position;
use App\Models\Master\Job;
use App\Models\Master\EmployeeType;
use App\Models\Master\Bank;
use App\Models\Master\AttachmentType;
use App\Models\Master\Industries;
use App\Models\Master\Specialization;
use App\Models\Master\EducationQualification;
use App\Models\Auth\UserBloodType;
use App\Models\Auth\UserGender;
use App\Models\Auth\UserMaritalStatus;
use App\Models\Auth\UserIdentityType;
use App\Models\Core\Country;
use App\Models\Core\Currency;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Models\Auth\UserConfirm;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;
use App\Models\Core\Attachment;
use Illuminate\Support\Facades\DB;

class EmployeeController extends MyController{

    public function __construct(){
        $this->model = new Employee;
        $this->route = "workers";
        $this->exportTitle = "DAFTAR_PEGAWAI";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            // Informasi Umum
            'division_id'=>'required',
            'job_id'=>'required',
            'type_id'=>'required',
            'position_id'=>'required',
            // Akun dan akses
            'username' => 'required|alpha_dash|unique:users',
            'email' => 'required|string|email|max:191|unique:users',
            'phone' => 'required|regex:/^[0-9]+$/|unique:users',
            'password' => 'required|string|min:6',
            'roles' => 'required|min:1',
            // Biodata
            'first_name'=>'required',
            'nick_name'=>'required',
            'birth_date'=>'required',
            'birth_place'=>'required',
            'gender_id'=>'required',
            'status_id'=>'required',
            'blood_id'=>'required',
            'use_lens'=>'required',
            'weight'=>'required',
            'height'=>'required',
            'country_id'=>'required',
            'identity_id'=>'required',
            'bank_id'=>'required',
            'account_number'=>'required',
            'tax_number'=>'required',
            'medical_number'=>'required',
            'address'=>'required'
        ];
	}
    
    protected function updateValidationCustom($id, $user_id){
		return [
            // Informasi Umum
            'division_id'=>'required',
            'job_id'=>'required',
            'type_id'=>'required',
            'position_id'=>'required',
            // Akun dan akses
            'username' => 'required|alpha_dash|unique:users,username,' . $user_id,
            'email' => 'required|email|unique:users,email,' .  $user_id,
            'phone' => 'required|regex:/^[0-9]+$/|unique:users,phone,'. $user_id,
            'roles' => 'required|min:1',
            // Biodata
            'first_name'=>'required',
            'nick_name'=>'required',
            'birth_date'=>'required',
            'birth_place'=>'required',
            'gender_id'=>'required',
            'status_id'=>'required',
            'blood_id'=>'required',
            'use_lens'=>'required',
            'weight'=>'required',
            'height'=>'required',
            'country_id'=>'required',
            'identity_id'=>'required',
            'bank_id'=>'required',
            'account_number'=>'required',
            'tax_number'=>'required',
            'medical_number'=>'required',
            'address'=>'required'
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        // Informasi Umum
        $items["divisions"] = Division::orderBy("name","ASC")->get();
        $items["positions"] = Position::orderBy("name","ASC")->get();
        $items["types"] = EmployeeType::orderBy("name","ASC")->get();
        $items["jobs"] = Job::orderBy("name","ASC")->get();
        // Akun dan Akses
        $items["roles"] = Role::orderBy("name","ASC")->get();
        // Biodata
        $items["genders"] = UserGender::orderBy("name","ASC")->get();
        $items["bloods"] = UserBloodType::orderBy("name","ASC")->get();
        $items["maritals"] = UserMaritalStatus::orderBy("name","ASC")->get();
        $items["countries"] = Country::orderBy("name","ASC")->get();
        $items["banks"] = Bank::orderBy("name","ASC")->get();
        $items["identities"] = UserIdentityType::orderBy("name","ASC")->get();
        // Lampiran
        $items["attachments"] = AttachmentType::orderBy("name","ASC")->get();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function store(Request $request){
        $rules = $this->storeValidation();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            // 1. Akun dan Akses
            $newUser = new User;
            $newUser->username = $request->get("username");
            $newUser->email = $request->get("email");
            $newUser->password = bcrypt($request->get('password'));
            $newUser->email_confirm = 1;
            $newUser->phone = $request->get("phone");
            $newUser->access_groups = \App\Helpers\UserHelper::accessGroups($request->get('roles', []));
            $newUser->save();
            $user_id = $newUser->id;
            $this->syncPermissions($request, $newUser);

            // 2. Biodata
            UserProfile::create([
                "user_id"=>$user_id,
                "bank_id"=>$request->get("bank_id") ? $request->get("bank_id") : null,
                "account_number"=>$request->get("account_number") ? $request->get("account_number") : null,
                "identity_number"=>$request->get("identity_number") ? $request->get("identity_number") : null,
                "tax_number"=>$request->get("tax_number") ? $request->get("tax_number") : null,
                "medical_number"=>$request->get("medical_number") ? $request->get("medical_number") : null,
                "family_number"=>$request->get("family_number") ? $request->get("family_number") : null,
                "nick_name"=>$request->get("nick_name") ? $request->get("nick_name") : null,
                "first_name"=>$request->get("first_name") ? $request->get("first_name") : null,
                "last_name"=>$request->get("last_name") ? $request->get("last_name") : null,
                "birth_date"=>$request->get("birth_date") ? $request->get("birth_date") : null,
                "birth_place"=>$request->get("birth_place") ? $request->get("birth_place") : null,
                "has_child"=>$request->get("has_child") ? $request->get("has_child") : 0,
                "total_child"=>$request->get("total_child") ? $request->get("total_child") : 0,
                "country_id"=>$request->get("country_id") ? $request->get("country_id") : null,
                "gender_id"=>$request->get("gender_id") ? $request->get("gender_id") : null,
                "status_id"=>$request->get("status_id") ? $request->get("status_id") : null,
                "blood_id"=>$request->get("blood_id") ? $request->get("blood_id") : null,
                "identity_id"=>$request->get("identity_id") ? $request->get("identity_id") : null,
                "postal_code"=>$request->get("postal_code") ? $request->get("postal_code") : null,
                "address"=>$request->get("address") ? $request->get("address") : null,
            ]);

            // 3. Informasi Umum
            $job_id = $request->get('job_id');
            $type_id = $request->get('type_id');
            $position_id = $request->get('position_id');
            $division_id = $request->get('division_id');
            $employee_number = Employee::createNumber($position_id, $division_id);
            $employee = Employee::create([
                "user_id"=>$user_id,
                "job_id"=>$job_id,
                "type_id"=>$type_id,
                "position_id"=>$position_id,
                "division_id"=>$division_id,
                "employee_number"=>$employee_number,
                "join_date"=>date("Y-m-d"),
                "is_banned"=>0,
                "is_blacklist"=>0,
                "weight"=>$request->get("weight") ? $request->get("weight") : 0,
                "height"=>$request->get("height") ? $request->get("height") : 0,
                "use_lens"=>$request->get("use_lens") ? $request->get("use_lens") : 0,
            ]);

            // 4. Lampiran
            $group_id = $request->get("group_id");
            if(count($group_id) > 0){
                if($request->hasfile('filename')){
                    $fileUpload = $request->file('filename');
                    for($i = 0; $i < count($group_id); $i++){
                        if(isset($fileUpload[$i])){
                            $file = $fileUpload[$i];
                            $name = md5(time()."_".str_random(100)).'.'.$file->getClientOriginalExtension();
                            $file->move(public_path().'/uploads/employees/', $name);  
                            $path = "uploads/employees/".$name;
                            $fileName = AttachmentType::findOrFail($group_id[$i])->name;
                            $attachment = Attachment::where("model_name", "App\Models\Employees\Employee")->where("model_id", $employee->id)->where("group_id", $group_id[$i])->first();
                            if(!is_null($attachment)){
                                if(file_exists($attachment->path)){
                                    unlink($attachment->path);
                                }
                                $attachment->name = $fileName;
                                $attachment->path = $path;
                                $attachment->type = mime_content_type(public_path("uploads/employees/".$name));
                                $attachment->size = filesize(public_path("uploads/employees/".$name));
                                $attachment->save();
                            }else{
                                Attachment::create([
                                    'is_folder'=>0,
                                    'name'=>$fileName,
                                    'path'=>$path,
                                    'type'=>mime_content_type(public_path("uploads/employees/".$name)),
                                    'size'=>filesize(public_path("uploads/employees/".$name)),
                                    'parent_id'=> null,
                                    'group_id'=>$group_id[$i],
                                    'model_id'=> $employee->id,
                                    'model_name'=>"App\Models\Employees\Employee"
                                ]);
                            }
                        }
                    }
                }
            }

            return redirect()->route($this->route.".show", ["id"=>$employee->id])->with('success', self::SUCCESS_MESSAGE_SAVED);
        }

    }

    public function edit($id){
        
        $employee = $this->model->findData($id);
        $user = User::findOrFail($employee->user_id);
        $profile = UserProfile::where("user_id", $employee->user_id)->first();
        
        foreach($user->getOriginal() as $key => $row){
           if($key != "id"){
                $employee->setAttribute($key, $row);
           }
        }
        $employee->setAttribute("roles", $user->roles);

        foreach($profile->getOriginal() as $key => $row){
            if($key != "user_id"){
                $employee->setAttribute($key, $row);
            }
        }


        $items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $employee;
        // Informasi Umum
        $items["divisions"] = Division::orderBy("name","ASC")->get();
        $items["positions"] = Position::orderBy("name","ASC")->get();
        $items["types"] = EmployeeType::orderBy("name","ASC")->get();
        $items["jobs"] = Job::orderBy("name","ASC")->get();
        // Akun dan Akses
        $items["roles"] = Role::orderBy("name","ASC")->get();
        // Biodata
        $items["genders"] = UserGender::orderBy("name","ASC")->get();
        $items["bloods"] = UserBloodType::orderBy("name","ASC")->get();
        $items["maritals"] = UserMaritalStatus::orderBy("name","ASC")->get();
        $items["countries"] = Country::orderBy("name","ASC")->get();
        $items["banks"] = Bank::orderBy("name","ASC")->get();
        $items["identities"] = UserIdentityType::orderBy("name","ASC")->get();
        // Lampiran
        $items["attachments"] = AttachmentType::orderBy("name","ASC")->get();
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }

    public function show($id){
		if((int)$id == 0){
            return $this->download();
        }else{
            $items = array();
            $employee = $this->model->findData($id);
            $user = User::findOrFail($employee->user_id);
            $profile = UserProfile::where("user_id", $employee->user_id)->first();

            foreach($user->getOriginal() as $key => $row){
               if($key != "id"){
                    $employee->setAttribute($key, $row);
               }
            }
            $employee->setAttribute("roles", $user->roles);
    
            foreach($profile->getOriginal() as $key => $row){
                if($key != "user_id"){
                    $employee->setAttribute($key, $row);
                }
            }

            $items = array();
            $items["metaPermission"] = $this->metaPermission();
            $items["data"] = $employee;

            // Akun dan Akses
            $items["roles"] = Role::orderBy("name","ASC")->get();

            // Biodata
            $items["gender"] = $profile->Gender()->first();
            $items["blood"] = $profile->Blood()->first();
            $items["marital"] = $profile->Status()->first();
            $items["country"] = $profile->Country()->first();
            $items["bank"] = $profile->Bank()->first();
            $items["identity"] = $profile->Identity()->first();

            // Lampiran
            $items["attachments"] = AttachmentType::orderBy("name","ASC")->get();
            $items["form"] = ["method"=>"DELETE", "route"=>[$this->route.'.destroy',  $id]];

            // Riawayat Pengalaman
            $items["experinces"] = EmployeeExperience::where("employee_id", $id)->orderBy("month_start","ASC")->orderBy("year_start","ASC")->get();
            $items["months"] = \App\Helpers\AppHelper::Months();
            $items["positions"] = Position::orderBy("name","ASC")->get();
            $items["divisions"] = Division::orderBy("name","ASC")->get();
            $items["industries"] = Industries::orderBy("name","ASC")->get();
            $items["specializations"] = Specialization::orderBy("name","ASC")->get();
            $items["countries"] = Country::orderBy("name","ASC")->get();
            $items["currencies"] = Currency::select(DB::raw('DISTINCT id, code1'))->where("code1","!=","")->get();

            // Riawayat Pendidikan
            $items["educations"] = EmployeeEducation::where("employee_id", $id)->orderBy("month_start","ASC")->orderBy("year_start","ASC")->get();
            $items["qualifications"] = EducationQualification::orderBy("name","ASC")->get();
        
            // Keahlian
            $items["specialist"] = EmployeeSpecialist::where("employee_id", $id)->orderBy("name","ASC")->get();
            $items["levels"] = \App\Helpers\AppHelper::Skills();

            // Bahasa
            $items["languages"] = Country::getAllLanguages();
            $items["toefl"] = EmployeeToefl::where("employee_id", $id)->orderBy("language","ASC")->get();

            $config = $this->onShow($items);
            return view('core.'.$this->route.'.show', $config);
        }
	}
    
    public function update(Request $request, $id){
        if((int) $id == 0){
            $eid = $request->get("eid");
            $employee_id = $request->get("employee_id");
            $attachment = Attachment::findOrFail($eid);
            if(file_exists($attachment->path)){
                unlink($attachment->path);
            }
            Attachment::where("id", $eid)->delete();
            return redirect()->route($this->route.'.show',['id'=>$employee_id])->with('success', 'Berhasil, Lampiran dokumen berhasil dihapus.');   
        }else{
            $user_id = $request->get("user_id");
            $rules = $this->updateValidationCustom($id, $user_id);
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator->errors())->withInput();
            }else{

                $oldEmployee = Employee::findOrFail($id);

                // 1. Akun dan Akses
                $newUser = User::findOrFail($user_id);
                $newUser->username = $request->get("username");
                $newUser->email = $request->get("email");

                if($request->get('password')){
                    $newUser->password = bcrypt($request->get('password'));
                }
                
                $newUser->email_confirm = 1;
                $newUser->phone = $request->get("phone");
                $newUser->access_groups = \App\Helpers\UserHelper::accessGroups($request->get('roles', []));
                $newUser->save();
                $user_id = $newUser->id;
                $this->syncPermissions($request, $newUser);

                // 2. Biodata
                UserProfile::where("user_id", $user_id)->update([
                    "bank_id"=>$request->get("bank_id") ? $request->get("bank_id") : null,
                    "account_number"=>$request->get("account_number") ? $request->get("account_number") : null,
                    "identity_number"=>$request->get("identity_number") ? $request->get("identity_number") : null,
                    "tax_number"=>$request->get("tax_number") ? $request->get("tax_number") : null,
                    "medical_number"=>$request->get("medical_number") ? $request->get("medical_number") : null,
                    "family_number"=>$request->get("family_number") ? $request->get("family_number") : null,
                    "nick_name"=>$request->get("nick_name") ? $request->get("nick_name") : null,
                    "first_name"=>$request->get("first_name") ? $request->get("first_name") : null,
                    "last_name"=>$request->get("last_name") ? $request->get("last_name") : null,
                    "birth_date"=>$request->get("birth_date") ? $request->get("birth_date") : null,
                    "birth_place"=>$request->get("birth_place") ? $request->get("birth_place") : null,
                    "has_child"=>$request->get("has_child") ? $request->get("has_child") : 0,
                    "total_child"=>$request->get("total_child") ? $request->get("total_child") : 0,
                    "country_id"=>$request->get("country_id") ? $request->get("country_id") : null,
                    "gender_id"=>$request->get("gender_id") ? $request->get("gender_id") : null,
                    "status_id"=>$request->get("status_id") ? $request->get("status_id") : null,
                    "blood_id"=>$request->get("blood_id") ? $request->get("blood_id") : null,
                    "identity_id"=>$request->get("identity_id") ? $request->get("identity_id") : null,
                    "postal_code"=>$request->get("postal_code") ? $request->get("postal_code") : null,
                    "address"=>$request->get("address") ? $request->get("address") : null,
                ]);

                // 3. Informasi Umum    
                $job_id = $request->get('job_id');
                $type_id = $request->get('type_id');
                $position_id = $request->get('position_id');
                $division_id = $request->get('division_id');

                $employee_number = null;
                if($oldEmployee->position_id == $position_id && $oldEmployee->division_id == $division_id){
                    $employee_number = $oldEmployee->employee_number;
                }else{
                    $employee_number = Employee::createNumber($position_id, $division_id);
                }

                $employee = Employee::where("id", $id)->update([
                    "job_id"=>$job_id,
                    "type_id"=>$type_id,
                    "position_id"=>$position_id,
                    "division_id"=>$division_id,
                    "employee_number"=>$employee_number,
                    "weight"=>$request->get("weight") ? $request->get("weight") : 0,
                    "height"=>$request->get("height") ? $request->get("height") : 0,
                    "use_lens"=>$request->get("use_lens") ? $request->get("use_lens") : 0,
                ]);

                // 4. Lampiran
                $group_id = $request->get("group_id");
                if(count($group_id) > 0){
                    if($request->hasfile('filename')){
                        $fileUpload = $request->file('filename');
                        for($i = 0; $i < count($group_id); $i++){
                            if(isset($fileUpload[$i])){
                                $file = $fileUpload[$i];
                                $name = md5(time()."_".str_random(100)).'.'.$file->getClientOriginalExtension();
                                $file->move(public_path().'/uploads/employees/', $name);  
                                $path = "uploads/employees/".$name;
                                $fileName = AttachmentType::findOrFail($group_id[$i])->name;
                                $attachment = Attachment::where("model_name", "App\Models\Employees\Employee")->where("model_id", $id)->where("group_id", $group_id[$i])->first();
                                if(!is_null($attachment)){
                                    if(file_exists($attachment->path)){
                                        unlink($attachment->path);
                                    }
                                    $attachment->name = $fileName;
                                    $attachment->path = $path;
                                    $attachment->type = mime_content_type(public_path("uploads/employees/".$name));
                                    $attachment->size = filesize(public_path("uploads/employees/".$name));
                                    $attachment->save();
                                }else{
                                    Attachment::create([
                                        'is_folder'=>0,
                                        'name'=>$fileName,
                                        'path'=>$path,
                                        'type'=>mime_content_type(public_path("uploads/employees/".$name)),
                                        'size'=>filesize(public_path("uploads/employees/".$name)),
                                        'parent_id'=> null,
                                        'group_id'=>$group_id[$i],
                                        'model_id'=> $id,
                                        'model_name'=>"App\Models\Employees\Employee"
                                    ]);
                                }
                            }
                        }
                    }
                }

                return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPATED);

            }
        }
	}
    
    private function syncPermissions(Request $request, $user){
        // Get the submitted roles
        $roles = $request->get('roles', []);
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::find($roles);

        // check for current role changes
        if(!$user->hasAllRoles($roles) ) {
            // reset all direct permissions for user
            $user->permissions()->sync([]);
        } else {
            // handle permissions
            $user->syncPermissions($permissions);
        }

        $user->syncRoles($roles);

        $confirm = UserConfirm::where("user_id", $user->id)->first();
        if(is_null($confirm)){
            $token = base64_encode(strtolower($user->email.'.'.str_random(40)));
            UserConfirm::Create([
                'user_id'=>$user->id,
                'token'=>$token
            ]);
        }

        return $user;
    }
}