<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Recruitment\Vacancy;
use App\Models\Master\Job;
use App\Models\Master\EmployeeType;
use App\Models\Organization\Division;
use App\Models\Organization\Position;

class VacancyController extends MyController{

    public function __construct(){
        $this->model = new Vacancy;
        $this->route = "vacancies";
        $this->exportTitle = "DAFTAR_LOWONGAN";
        $this->useCode = false;
    }

    protected function storeValidation(){
		return [
            'name' => 'required',
            "type_id"=> 'required',
            "job_id"=> 'required',
            "position_id"=> 'required',
            "division_id"=> 'required',
            "start_date"=> 'required',
            "end_date"=> 'required',
            "description"=> 'required',
            "min_salary"=> 'required',
            "max_salary"=> 'required',
        ];
	}
    
    protected function updateValidation($id){
		return [
            'name' => 'required',
            "type_id"=> 'required',
            "job_id"=> 'required',
            "position_id"=> 'required',
            "division_id"=> 'required',
            "start_date"=> 'required',
            "end_date"=> 'required',
            "description"=> 'required',
            "min_salary"=> 'required',
            "max_salary"=> 'required',
        ];
    }

    public function create(){
		$items = array();
        $items["metaPermission"] = $this->metaPermission();
        $items["jobs"] = Job::orderBy("name", "ASC")->get();
        $items["types"] = EmployeeType::orderBy("name", "ASC")->get();
        $items["division"] = Division::orderBy("name", "ASC")->get();
        $items["position"] = Position::orderBy("name", "ASC")->get();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
    }

    public function edit($id){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        $items["data"] = $this->model->findData($id);
        $items["metaPermission"] = $this->metaPermission();
        $items["jobs"] = Job::orderBy("name", "ASC")->get();
        $items["types"] = EmployeeType::orderBy("name", "ASC")->get();
        $items["division"] = Division::orderBy("name", "ASC")->get();
        $items["position"] = Position::orderBy("name", "ASC")->get();
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
    }

    protected function beforeStore(Request $request){
        $request["min_salary"] = $request["min_salary"] ? \App\Helpers\AppHelper::truncateFormatNumber($request["min_salary"])  : 0;
        $request["max_salary"] = $request["max_salary"] ? \App\Helpers\AppHelper::truncateFormatNumber($request["max_salary"])  : 0;
    }
    
    protected function beforeUpdate(Request $request, $id){
        $request["min_salary"] = $request["min_salary"] ? \App\Helpers\AppHelper::truncateFormatNumber($request["min_salary"])  : 0;
        $request["max_salary"] = $request["max_salary"] ? \App\Helpers\AppHelper::truncateFormatNumber($request["max_salary"])  : 0;
    }
    
   

    
}