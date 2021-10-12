<?php

namespace App\Models\Recruitment;

use Illuminate\Database\Eloquent\Model;
// Relations
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Vacancy;
use App\Models\Employees\Employee;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Models\Auth\UserConfirm;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;
use Illuminate\Http\Request;
use App\Models\Core\Attachment;
use App\Models\Master\AttachmentType;

class Acceptance extends Model{

    protected $table = 'employee_acceptance';
    protected $fillable = [
        "vacancy_id",
        "candidate_id",
        "agency_id",
        "pskikotest_score",
        "technical_score",
        "healthy_score",
        "interview_score",
        "hrd_id",
        "manager_id",
        "hrd_approved",
        "manager_approved",
        "hrd_notes",
        "manager_notes"
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                'id',
                "vacancy_id",
                "candidate_id",
                "agency_id",
                "pskikotest_score",
                "technical_score",
                "healthy_score",
                "interview_score",
                "hrd_id",
                "manager_id",
                "hrd_approved",
                "manager_approved",
                "hrd_notes",
                "manager_notes",
                'created_at'
            ),
            "filter"=> array(
                'id',
                'name',
                'email',
                'phone',
                'website',
                'postal_code',
                'address',
                'created_at'
            ),
        ];
    }

    public function exportDataColumn(){
        return [];
    }

    public function Candidate(){
        return $this->belongsTo(Candidate::class, "candidate_id");
    }

    public function Recruter(){
        return $this->belongsTo(Employee::class, "hrd_id");
    }

    public function Manager(){
        return $this->belongsTo(Employee::class, "manager_id");
    }

    public function Vacancy(){
        return $this->belongsTo(Vacancy::class, "vacancy_id");
    }

    public function storeEmployee($request, $id){
        $data = self::findOrfail($id);
        $candidate = $data->Candidate;
        $vacancy = $data->Vacancy;

        $staff = Role::where("name", "Staff")->first() ? $staff->id : array();

        // 1. Akun dan Akses
        $email = $this->createEmail($candidate->email);
        $username = $this->createUsername($candidate->first_name."".$candidate->last_name);
        $newUser = new User;
        $newUser->username = $username;
        $newUser->email = $email;
        $newUser->password = bcrypt("secret");
        $newUser->email_confirm = 1;
        $newUser->phone = $this->checkPhone($candidate->phone) ? $candidate->phone : null;
        $newUser->access_groups = \App\Helpers\UserHelper::accessGroups([$staff]);
        $newUser->save();
        $user_id = $newUser->id;
        $this->syncPermissions($request, $newUser);

        // 2. Biodata
        UserProfile::create([
            "user_id"=>$user_id,
            "identity_number"=>$candidate->identity_number,
            "first_name"=>$candidate->first_name,
            "last_name"=>$candidate->last_name,
            "birth_date"=>$candidate->birth_date,
            "birth_place"=>$candidate->birth_place,
            "country_id"=>$candidate->country_id,
            "gender_id"=>$candidate->gender_id,
            "status_id"=>$candidate->status_id,
            "blood_id"=>$candidate->blood_id,
            "identity_id"=>$candidate->identity_id,
            "postal_code"=>$candidate->postal_code,
            "address"=>$candidate->address,
        ]);
        
        // 3. Informasi Umum
        $job_id = $vacancy->job_id;
        $type_id = $vacancy->type_id;
        $position_id = $vacancy->position_id;
        $division_id =  $vacancy->division_id;
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
        ]);

        // Attachment
        $attachments = AttachmentType::all();
        foreach($attachments as $attachment){
            $file = \App\Helpers\AppHelper::getFileByGroup("App\Models\Recruitment\Candidate", $candidate->id,  $attachment->id);
            if(!is_null($file)){
                Attachment::create([
                    'is_folder'=>0,
                    'name'=>$file->name,
                    'path'=>$file->path,
                    'type'=>$file->type,
                    'size'=>$file->size,
                    'parent_id'=> $file->parent_id,
                    'group_id'=>$file->group_id,
                    'model_id'=> $employee->id,
                    'model_name'=>"App\Models\Employees\Employee"
                ]);
            }
        }

        return $newUser;

    }

    private function checkPhone($phone){
        $user = User::where("phone", $phone)->first();
        return !is_null($user) ? true : false;
    }

    private function createEmail($email){
        $user = User::where("email", $email)->first();
        $indexUser = ((int) User::max("id")) + 1;
        if(!is_null($user)){
            return $email."".$indexUser;
        }else{
            return $email;
        }
    }

    private function createUsername($text){
        $username = strtolower(str_replace(" ", null, $text));
        $indexUser = ((int) User::max("id")) + 1;
        $user = User::where("username", $username)->first();
        if(!is_null($user)){
            return $username."".$indexUser;
        }else{
            return $username;
        }
    }

    private function syncPermissions(Request $request, $user){
        // Get the submitted roles
        $permissions = $request->get('permissions', []);

        // Get the roles
        $roles = Role::where("name", "Staff")->first();

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