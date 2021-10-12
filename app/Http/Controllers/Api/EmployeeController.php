<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Models\Employees\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EmployeeController extends ApiController{

    public function __construct() {
        parent::__construct();
        $this->model = new Employee;
    }

    public function getEmployee(Request $request){
        $search = $request->get("q");
        $result = Employee::select(DB::raw("employees.id as id, CONCAT(employees.employee_number,' - ',CONCAT(users_profile.first_name,' ',users_profile.last_name)) as text"))
        ->Leftjoin('users_profile', function($join) {
            $join->on('users_profile.user_id', '=', 'employees.user_id');
        })
        ->Leftjoin('employee_divisions', function($join) {
            $join->on('employee_divisions.id', '=', 'employees.division_id');
        })
        ->Leftjoin('employee_positions', function($join) {
            $join->on('employee_positions.id', '=', 'employees.position_id');
        })
        ->Leftjoin('employee_type', function($join) {
            $join->on('employee_type.id', '=', 'employees.type_id');
        })
        ->Leftjoin('employee_jobs', function($join) {
            $join->on('employee_jobs.id', '=', 'employees.job_id');
        })
        ->Leftjoin('users_marital_status', function($join) {
            $join->on('users_marital_status.id', '=', 'users_profile.status_id');
        })
        ->Leftjoin('users_genders', function($join) {
            $join->on('users_genders.id', '=', 'users_profile.gender_id');
        })
        ->where(function($q) use ($search) {
            $q->where('users_profile.first_name', 'LIKE', '%'.$search.'%');
            $q->Orwhere('users_profile.last_name', 'LIKE', '%'.$search.'%');
            $q->Orwhere('employees.employee_number', 'LIKE', '%'.$search.'%');
        })->take(10)->orderBy("first_name","ASC")->get();
        return response()->json($result);
    }

    public function findEmployee(Request $request, $id){
        $result = $this->model->where("employees.id", $id)->first();
        if(!is_null($result)){
            $result->setAttribute("division", $result->Division);
            return response()->json($result);
        }else{
            return response()->json(array(null));
        }
    }

}