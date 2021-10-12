<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Organization\Position;


class PositionController extends MyController{

    public function __construct(){
        $this->model = new Position;
        $this->route = "positions";
        $this->exportTitle = "DAFTAR_POSISI";
        $this->useCode = true;
        $this->codeIndex = "P";
    }

    protected function storeValidation(){
		return [
            'name' => 'required|string|max:191|unique:employee_positions'
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required|string|max:191|unique:employee_positions,name,' . $id
        ];
    }
    
    public function store(Request $request){
        $rules = $this->storeValidation();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            $post = $request->all();
            $post["code"] = $this->model->createCode($this->codeIndex);
            $post["hour_salary"] = $post["hour_salary"] ? \App\Helpers\AppHelper::truncateFormatNumber($post["hour_salary"])  : 0;
            $post["month_salary"] = $post["month_salary"] ? \App\Helpers\AppHelper::truncateFormatNumber($post["month_salary"])  : 0;
            $data = $this->model->create($post);
			$id = $data->id;
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_SAVED);
        }
    }

    public function update(Request $request, $id){
        $rules = $this->updateValidation($id);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
            $post = $request->all();
            $post["hour_salary"] = $post["hour_salary"] ? \App\Helpers\AppHelper::truncateFormatNumber($post["hour_salary"])  : 0;
            $post["month_salary"] = $post["month_salary"] ? \App\Helpers\AppHelper::truncateFormatNumber($post["month_salary"])  : 0;
            $data = $this->model->findData($id);
            $data->fill($post);
			$data->save();
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_SAVED);
        }
    }

    
}