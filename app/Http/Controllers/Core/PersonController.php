<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Core\Person;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Models\Auth\UserConfirm;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;

class PersonController extends MyController{

    public function __construct(){
        $this->model = new Person;
        $this->route = "users";
        $this->exportTitle = "DAFTAR_PENGGUNA";
        $this->useCode = false;
    }

    public function index(){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        return view('core.'.$this->route.'.index', $items);
	}

    public function create(){
		return abort(404);    
    }
    
    public function store(Request $request){
        return abort(404);    
    }

    public function update(Request $request, $id){
        $rules = [
            'username' => 'required|alpha_dash|unique:users,username,' . $id,
            'email' => 'required|email|unique:users,email,' . $id,
            'roles' => 'required|min:1',
        ];

        if($request->get('phone')) $rules["phone"] = 'required|regex:/^[0-9]+$/|unique:users,phone,'.$id;
        if($request->get('password')) $rules["phone"] = 'min:1';

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            $user = User::findOrfail($id);
            $user->username = $request->get("username");
            $user->email = $request->get("email");
            $user->access_groups = \App\Helpers\UserHelper::accessGroups($request->get('roles', []));
            if($request->get("password")) $user->password = bcrypt($request->get('password'));
            if($request->get("phone")) $user->phone = $request->get("phone");
            $user->save();
            $id = $user->id;
            $this->syncPermissions($request, $user);
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_SAVED);
        }
    }

     public function show($id){
        if((int)$id == 0) return $this->download();
        
        $user = User::findOrfail($id);
        if($user->is_root || $id == \Auth::User()->id) return abort(404);   
        $items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["data"] = $user;
        $items["form"] = ["method"=>"DELETE", "route"=>[$this->route.'.destroy',  $id]];
        $config = $this->onShow($items);
        return view('core.'.$this->route.'.show', $config);
    }
    
    public function edit($id){
        $user = User::findOrfail($id);
        if($user->is_root || $id == \Auth::User()->id) return abort(404);   
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $user;
        $items["roles"] = Role::all();
        $config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
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

        $profile = UserProfile::where("user_id", $user->id)->first();
        if(is_null($profile)){
            UserProfile::create(["user_id"=>$user->id]);
        }

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