<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employees\EmployeePayroll;
use App\Models\Employees\EmployeeAbsence;
use App\Models\Organization\Division;
use App\Models\Employees\Employee;
use App\Models\Master\Holiday;
use Carbon\Carbon;
use DB;

class EmployeeDashboard extends Model{

    public function getEmployeeChart(){
        $div = array();
        $data = array();
        $division = Division::orderBy("name","ASC")->get();
        foreach($division as $row){
            $div[] = ucfirst(strtolower($row->name));
            $data[] = Employee::where("division_id", $row->id)->count();
        }
        return array("division"=>$div, "data"=>$data);
    }

    public function countOvertimeChart($month, $year, $status, $all = false){
        $where  = $all ? "employee_over_time.is_approved >= 0" : "employee_over_time.is_approved = ".$status."";
        $sql = "
             SELECT  COUNT(*) as total FROM employee_over_time 
             WHERE ".$where."
             AND MONTH(employee_over_time.request_date) = ".$month."
             AND YEAR(employee_over_time.request_date) = ".$year."
             AND employee_over_time.deleted_at IS NULL
        ";
         $query = trim(preg_replace('/\s+/', ' ', $sql));  
         $data =  DB::select($query);
         return isset($data[0]->total) ? (int) $data[0]->total : 0;
     }

    public function countTravelChart($month, $year, $status, $all = false){
       $where  = $all ? "employee_travel.is_approved >= 0" : "employee_travel.is_approved = ".$status."";
       $sql = "
            SELECT  COUNT(*) as total FROM employee_travel 
            WHERE ".$where."
            AND MONTH(employee_travel.start_date) = ".$month."
            AND YEAR(employee_travel.start_date) = ".$year."
            AND employee_travel.deleted_at IS NULL
       ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return isset($data[0]->total) ? (int) $data[0]->total : 0;
    }

    public function countAnnualChart($month, $year, $status, $all = false){
       $where  = $all ? "employee_annual.is_approved >= 0" : "employee_annual.is_approved = ".$status."";
       $sql = "
            SELECT  COUNT(*) as total FROM employee_annual 
            WHERE ".$where."
            AND MONTH(employee_annual.start_date) = ".$month."
            AND YEAR(employee_annual.start_date) = ".$year."
            AND employee_annual.deleted_at IS NULL
       ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return isset($data[0]->total) ? (int) $data[0]->total : 0;
    }

   

    public function countOverTime($month, $year){
        $sql = "
            SELECT COUNT(*) as total FROM employee_over_time 
            WHERE  MONTH(employee_over_time.request_date) = ".$month."
            AND YEAR(employee_over_time.request_date) = ".$year."
            AND employee_over_time.deleted_at IS NULL
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return isset($data[0]->total) ? (int) $data[0]->total : 0;
    }

    public function countAnnual($month, $year){
        $sql = "
            SELECT  COUNT(*) as total FROM employee_annual 
            WHERE MONTH(employee_annual.start_date) = ".$month."
            AND YEAR(employee_annual.start_date) = ".$year."
            AND employee_annual.deleted_at IS NULL
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return isset($data[0]->total) ? (int) $data[0]->total : 0;
    }

    public function countTravel($month, $year){
        $sql = "
            SELECT  COUNT(*) as total FROM employee_travel 
            WHERE MONTH(employee_travel.start_date) = ".$month."
            AND YEAR(employee_travel.start_date) = ".$year."
            AND employee_travel.deleted_at IS NULL
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return isset($data[0]->total) ? (int) $data[0]->total : 0;
    }

}