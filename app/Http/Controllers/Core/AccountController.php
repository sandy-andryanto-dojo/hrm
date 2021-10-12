<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Auth\User;

class AccountController extends MyController{

    public function __construct(){
        $this->model = new User;
        $this->route = "accounts";
        $this->useCode = false;
    }

    public function index(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["data"] = \Auth::User();
        return view('core.'.$this->route.'.index', $items);
	}

    public function store(Request $request){
        $user_id = \Auth::User()->id;

        $rules = [
            'username' => 'required|alpha_dash|unique:users,username,' . $user_id,
            'email' => 'required|email|unique:users,email,' . $user_id,
        ];

        if($request->get('password')) $rules["password"] = 'required|string|min:6';
        if($request->get('phone')) $rules["phone"] = 'required|regex:/^[0-9]+$/|unique:users,phone,'.$user_id;

        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }else{
            $user = \Auth::User();
            $user->username = $request->get("username");
            $user->email = $request->get("email");
            if ($request->get("password")) $user->password = bcrypt($request->get('password'));
            if ($request->get("phone")) $user->phone = $request->get('phone');
            $user->save();
            return redirect()->route($this->route.'.index')->with('success', 'Akun anda berhasil diubah.');
        } 
	}
    
    public function create(){
        return abort(404);    
    }

    public function show($id){
        return abort(404);   
    }

    public function edit($id){
        return abort(404);   
    }

    public function update(Request $request, $id){
        return abort(404);  
    }

    public function destroy($id){
        return abort(404);   
    }
    
}