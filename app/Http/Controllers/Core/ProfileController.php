<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Auth\UserProfile;
use App\Models\Auth\UserBloodType;
use App\Models\Auth\UserGender;
use App\Models\Auth\UserMaritalStatus;
use App\Models\Auth\UserIdentityType;
use App\Models\Organization\Division;
use App\Models\Organization\Position;
use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeExperience;
use App\Models\Employees\EmployeeEducation;
use App\Models\Employees\EmployeeSpecialist;
use App\Models\Employees\EmployeeToefl;
use App\Models\Master\EducationQualification;
use App\Models\Master\Specialization;
use App\Models\Master\Industries;
use App\Models\Master\AttachmentType;
use App\Models\Core\Country;
use App\Models\Core\Currency;
use App\Models\Core\Attachment;
use App\Models\Master\Bank;
use Illuminate\Support\Facades\DB;

class ProfileController extends MyController{

    public function __construct(){
        $this->model = new UserProfile;
        $this->route = "profiles";
        $this->useCode = false;
    }

    public function index(){
        $user_id = \Auth::User()->id;
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["data"] = Employee::where("user_id", $user_id)->first();
        $items["genders"] = UserGender::orderBy("name","ASC")->get();
        $items["bloods"] = UserBloodType::orderBy("name","ASC")->get();
        $items["maritals"] = UserMaritalStatus::orderBy("name","ASC")->get();
        return view('core.'.$this->route.'.index', $items);
	}

    public function store(Request $request){
        $redirect = $request->get("redirect");
        $user_id = \Auth::User()->id;
        $employee = Employee::where("user_id", $user_id)->first();
        if((int) $redirect == 1){
            $input_employee = [
                "weight"=>$request->get("weight"),
                "height"=>$request->get("height"),
                "use_lens"=>$request->get("use_lens"),
            ];
            $input_profile = $request->except(['_method','_token','redirect','use_lens','weight','height']);
            $input_profile["birth_date"] = $input_profile["birth_date"] ? $input_profile["birth_date"] : null;
            $input_profile["bank_id"] = $input_profile["bank_id"] ? $input_profile["bank_id"] : null;
            $input_profile["identity_id"] = $input_profile["identity_id"] ? $input_profile["identity_id"] : null;
            $input_profile["country_id"] = $input_profile["country_id"] ? $input_profile["country_id"] : null;
            $user_id = \Auth::User()->id;
            UserProfile::where("user_id", $user_id)->update($input_profile);
            Employee::where("user_id", $user_id)->update($input_employee);
            return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, biodata anda berhasil diubah.');
        }else if((int) $redirect == 2){
            $id = $request->get("id");
            $input_data = $request->except(['_method','_token','redirect','id']);
            $input_data["employee_id"] = $employee->id;
            $input_data["sallary"] = $input_data["sallary"] ? \App\Helpers\AppHelper::truncateFormatNumber($input_data["sallary"])  : 0;
            if($id){
                EmployeeExperience::where("id", $id)->update($input_data);
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, Pengalaman kerja berhasil diubah.');
            }else{
                EmployeeExperience::create($input_data);
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, Pengalaman kerja berhasil ditambahkan');
            }
        }else if((int) $redirect == 3){
            $id = $request->get("id");
            $input_data = $request->except(['_method','_token','redirect','id']);
            $input_data["employee_id"] = $employee->id;
            if($id){
                EmployeeEducation::where("id", $id)->update($input_data);
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, Riwayat pendidikan berhasil diubah.');
            }else{
                EmployeeEducation::create($input_data);
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, Riwayat pendidikan berhasil ditambahkan');
            }
        }else if((int) $redirect == 4){
            $id = $request->get("id");
            $input_data = $request->except(['_method','_token','redirect','id']);
            $input_data["employee_id"] = $employee->id;
            if($id){
                EmployeeSpecialist::where("id", $id)->update($input_data);
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, Keahlian berhasil diubah.');
            }else{
                EmployeeSpecialist::create($input_data);
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, Keahlian berhasil ditambahkan');
            }
        }else if((int) $redirect == 5){
            $id = $request->get("id");
            $input_data = $request->except(['_method','_token','redirect','id']);
            $input_data["employee_id"] = $employee->id;
            if($id){
                EmployeeToefl::where("id", $id)->update($input_data);
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, Kemampuan berbahasa berhasil diubah.');
            }else{
                EmployeeToefl::create($input_data);
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, Kemampuan berbahasa berhasil ditambahkan');
            }

        }else if((int) $redirect == 6){
            $id = $request->get("id");
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
                return redirect()->route($this->route.'.show',['id'=>$redirect])->with('success', 'Berhasil, lampiran dokumen pegawai berhasil diperbaharui');
            }
        }else{
            return abort(404);    
        }
	}
    
    public function create(){
        return abort(404);    
    }

    public function show($id){
        $user_id = \Auth::User()->id;
        $types = [1,2,3,4,5,6];
        $employee = Employee::where("user_id", $user_id)->first();
        if(in_array($id, $types)){
            $items = array();
            $items["metaPermission"] = $this->metaPermission();
            switch($id){
                case 1: 
                    $items["redirect"] = 1;
                    $items["data"] = \Auth::User();
                    $items["employee"] = $employee;
                    $items["genders"] = UserGender::orderBy("name","ASC")->get();
                    $items["bloods"] = UserBloodType::orderBy("name","ASC")->get();
                    $items["maritals"] = UserMaritalStatus::orderBy("name","ASC")->get();
                    $items["countries"] = Country::orderBy("name","ASC")->get();
                    $items["banks"] = Bank::orderBy("name","ASC")->get();
                    $items["identities"] = UserIdentityType::orderBy("name","ASC")->get();
                break;
                case 2: 
                    $items["redirect"] = 2;
                    $items["data"] = EmployeeExperience::where("employee_id", $employee->id)->orderBy("month_start","ASC")->orderBy("year_start","ASC")->get();
                    $items["months"] = \App\Helpers\AppHelper::Months();
                    $items["positions"] = Position::orderBy("name","ASC")->get();
                    $items["divisions"] = Division::orderBy("name","ASC")->get();
                    $items["industries"] = Industries::orderBy("name","ASC")->get();
                    $items["specializations"] = Specialization::orderBy("name","ASC")->get();
                    $items["countries"] = Country::orderBy("name","ASC")->get();
                    $items["currencies"] = Currency::select(DB::raw('DISTINCT id, code1'))->where("code1","!=","")->get();
                break;
                case 3: 
                    $items["redirect"] = 3;
                    $items["data"] = EmployeeEducation::where("employee_id", $employee->id)->orderBy("month_start","ASC")->orderBy("year_start","ASC")->get();
                    $items["qualifications"] = EducationQualification::orderBy("name","ASC")->get();
                    $items["countries"] = Country::orderBy("name","ASC")->get();
                    $items["months"] = \App\Helpers\AppHelper::Months();
                break;
                case 4: 
                    $items["redirect"] = 4;
                    $items["data"] = EmployeeSpecialist::where("employee_id", $employee->id)->orderBy("name","ASC")->get();
                    $items["levels"] = \App\Helpers\AppHelper::Skills();
                break;
                case 5: 
                    $items["redirect"] = 5;
                    $items["languages"] = Country::getAllLanguages();
                    $items["data"] = EmployeeToefl::where("employee_id", $employee->id)->orderBy("language","ASC")->get();
                break;
                case 6: 
                    $items["eid"] = $employee->id;
                    $items["redirect"] = 6;
                    $items["types"] = AttachmentType::orderBy("name","ASC")->get();
                break;
            }
            return view('core.profiles.show'.$id, $items);
        }else{
            return abort(404);   
        }
    }

    public function edit($id){
        return abort(404);   
    }

    public function update(Request $request, $id){
        $eid = $request->get("eid");
        if((int) $id == 2){
            EmployeeExperience::where("id", $eid)->delete();
            return redirect()->route($this->route.'.show',['id'=>$id])->with('success', 'Berhasil, Pengalaman kerja berhasil dihapus.');
        }else if((int) $id == 3){
            EmployeeEducation::where("id", $eid)->delete();
            return redirect()->route($this->route.'.show',['id'=>$id])->with('success', 'Berhasil, Riwayat pendidikan berhasil dihapus.');
        }else if((int) $id == 4){
            EmployeeSpecialist::where("id", $eid)->delete();
            return redirect()->route($this->route.'.show',['id'=>$id])->with('success', 'Berhasil, Keahlian berhasil dihapus.');
        }else if((int) $id == 5){   
            EmployeeToefl::where("id", $eid)->delete();
            return redirect()->route($this->route.'.show',['id'=>$id])->with('success', 'Berhasil, Kemampuan berbahasa berhasil dihapus.');   
        }else if((int) $id == 6){
            $attachment = Attachment::findOrFail($eid);
            if(file_exists($attachment->path)){
                unlink($attachment->path);
            }
            Attachment::where("id", $eid)->delete();
            return redirect()->route($this->route.'.show',['id'=>$id])->with('success', 'Berhasil, Lampiran dokumen berhasil dihapus.');   
        }else{
            return abort(404);   
        }
    }

    public function destroy($id){
        return abort(404);   
    }
    
}