<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Core\Group;
use App\Models\Auth\Role;
use App\Models\Auth\Permission;

class GroupController extends MyController{

    public function __construct(){
        $this->model = new Group;
        $this->route = "roles";
        $this->exportTitle = "DAFTAR_AKSES";
        $this->useCode = false;
    }

    public function index(){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        return view('core.'.$this->route.'.index', $items);
	}

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["permissions"] = [
            Permission::where("name", "LIKE", "%view%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%add%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%edit%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%delete%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
        ];
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function store(Request $request){
        $rules = [
            'name' => 'required|unique:roles',
            'permissions' => 'required|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            $role = Role::create($request->only('name'));
            $permissions = $request->get('permissions', []);
            $actions =  ["view","add","edit","delete"];
            $addons = ["profiles","accounts","notifications"];
            foreach($actions as $action){
                foreach($addons as $add){
                    $permissions[] = $action."_".$add;
                }
            }
            $role->syncPermissions($permissions);
            $id = $role->id;
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_SAVED);
        }
    }

    public function show($id){
		if((int)$id == 0) return $this->download();
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
		$items["data"] = Role::findOrfail($id);
        $items["form"] = ["method"=>"DELETE", "route"=>[$this->route.'.destroy',  $id]];
        $items["permissions"] = [
            Permission::where("name", "LIKE", "%view%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%add%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%edit%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%delete%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
        ];
		$config = $this->onShow($items);
		return view('core.'.$this->route.'.show', $config);
    }

    public function edit($id){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = Role::findOrfail($id);
        $items["permissions"] = [
            Permission::where("name", "LIKE", "%view%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%add%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%edit%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
            Permission::where("name", "LIKE", "%delete%")->where("name","NOT LIKE","%accounts%")->where("name","NOT LIKE","%profiles%")->where("name","NOT LIKE","%notifications%")->orderBy("name", "ASC")->get(),
        ];
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }
    
    public function update(Request $request, $id){
        $rules = [
            'name' => 'required|unique:roles,name,' . $id,
            'permissions' => 'required|min:1',
        ];
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            $role = Role::findOrfail($id);
            $role->name = $request->get("name");
            $permissions = $request->get('permissions', []);
            $role->save();
            $actions =  ["view","add","edit","delete"];
            $addons = ["profiles","accounts","notifications"];
            foreach($actions as $action){
                foreach($addons as $add){
                    $permissions[] = $action."_".$add;
                }
            }
            $role->syncPermissions($permissions);
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_SAVED);
        }
    }
}