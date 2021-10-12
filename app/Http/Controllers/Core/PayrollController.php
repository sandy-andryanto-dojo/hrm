<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\Employee;
use App\Models\Auth\User;
use App\Models\Auth\UserProfile;
use App\Models\Employees\EmployeeAllowance;
use App\Models\Master\AllowanceType;
use App\Models\Employees\EmployeeCut;
use App\Models\Employees\EmployeeOverTime;
use App\Models\Employees\EmployeeTravel;
use App\Models\Employees\EmployeeAnnual;
use App\Models\Employees\EmployeeAbsence;   
use App\Models\Employees\EmployeePayroll;
use App\Models\Employees\EmployeePayrollItems;
use App\Models\Master\LossType;

class PayrollController extends MyController{

    public function __construct(){
        $this->model = new Employee;
        $this->route = "payrolls";
        $this->exportTitle = "";
        $this->useCode = false;
    }

    public function index(){
        if(!\Auth::User()->isAdmin()){
            $id = \Auth::User()->getEmployeeId();
            return redirect()->route("payrolls.detail", ["month"=>$month, "year"=> $year, "id"=>$id]);
        }
        $month = (int) date("m");
        $year = (int) date("Y");
        return redirect()->route("payrolls.current", ["month"=>$month, "year"=> $year]);
    }

    public function current($month, $year){
        if(!\Auth::User()->isAdmin()){
            $id = \Auth::User()->getEmployeeId();
            return redirect()->route("payrolls.detail", ["month"=>$month, "year"=> $year, "id"=>$id]);
        }
        $items = array();
        $items["month"]  = $month;
        $items["year"] = $year;
        $items["metaPermission"] = $this->metaPermission();
        $items["month_name"] = \App\Helpers\AppHelper::getMonth($month);
        return view('core.'.$this->route.'.index', $items);
    }

    public function detail($month, $year, $id){
        $items = $this->getItems($month, $year, $id);
        return view('core.'.$this->route.'.show', $items);
    }

    public function printInvoice($month, $year, $id){
        $items = $this->getItems($month, $year, $id);
        return view('core.'.$this->route.'.print', $items);
    }

    public function confirm(Request $request){
        $id = $request->get("employee_id");
        $month = $request->get("month");
        $year = $request->get("year");
        $items = $this->getItems($month, $year, $id);
        $periode = "Bulan ".$items["month_name"]." Tahun ".$year;

        EmployeePayroll::where("employee_id", $id)
            ->where("month", $month)
            ->where("year", $year)
            ->delete();
        
        EmployeePayrollItems::join("employee_payroll", "employee_payroll.id","=","employee_payroll_items.payroll_id")
            ->where("employee_id", $id)
            ->where("month", $month)
            ->where("year", $year)
            ->delete();
        
        $employee = Employee::findOrfail($id);
        $allowances = $items["allowances"];
        $cuts = $items["cuts"];
        $payment_number = EmployeePayroll::createInvoiceNumber($month, $year);

        $payroll = EmployeePayroll::create([
            "employee_id"=>$id,
            "payment_number"=>$payment_number,
            "payment_date"=>now(),
            "total_absence"=>$items["totalAbsenceByDays"],
            "basic_pay"=>$employee->Position->month_salary,
            "total_allowance"=>$items["totalAllowances"],
            "total_loss"=>$items["totalCuts"],
            "take_home_salary"=>$items["takeHome"],
            "month"=>$month,
            "year"=>$year,
        ]);

        foreach($allowances as $a){
            EmployeePayrollItems::create([
                "payroll_id"=>$payroll->id,
                "model_type"=>"App\Models\Master\AllowanceType",
                "model_id"=>$a["id"],
                "cost"=>$a["cost"],
            ]);
        }

        foreach($cuts as $c){
            EmployeePayrollItems::create([
                "payroll_id"=>$payroll->id,
                "model_type"=>"App\Models\Master\LossType",
                "model_id"=>$c["id"],
                "cost"=>$c["cost"],
            ]);
        }

        return redirect()->route("payrolls.detail", ["month"=>$month, "year"=> $year, "id"=>$id])->with('success', "Konfirmasi penggajian periode ".$periode." sudah dikonfirmasi.");
    }
    
    private function getItems($month, $year, $id){
        $items = array();
        $employee = $this->model->findData($id);
        $user = User::findOrFail($employee->user_id);
        $profile = UserProfile::where("user_id", $employee->user_id)->first();
        $totalAllowances = 0;
        $totalCuts = 0;

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

        $totalAbsenceByDays = EmployeeAbsence::getTotalDaysByEmployee($month, $year, $id, false); // total absence by day
        $totalAbsenceByDaysLeave = EmployeeAbsence::getTotalDaysByEmployee($month, $year, $id, true); // total absence by day leave
        $totalAbsenceByHours = EmployeeAbsence::getTotalHoursByEmployee($month, $year, $id); // total absence by hours
        $totalAnnual = EmployeeAnnual::getTotalDaysByEmployee($month, $year, $id); // total cuti
        $totalOverTimes = EmployeeOverTime::getTotalHoursByEmployee($month, $year, $id); // total lembur
        $totalTravelDays = EmployeeTravel::getTotalDaysByEmployee($month, $year, $id); // total on site
        $totalReimburse = EmployeeTravel::getReimburse($month, $year, $id); // total reinburst
        $totaldays = EmployeeAbsence::getTotalDays($month, $year, $id);
        $totalhours = EmployeeAbsence::getTotalHours($month, $year, $id);

        // Allowances
        $allowance_types = AllowanceType::orderBy("name", "ASC")->get();
        $allowances = array();
        foreach($allowance_types as $type){

            $temp = EmployeeAllowance::where("employee_id", $id)->where("type_id", $type->id)->first();

            if(!is_null($temp)){

                // Lembur
                if(\App\Helpers\AppHelper::isEquals($type->name, "Lembur")){
                    $temp->cost = $temp->cost * $totalOverTimes;
                }

                // Transportasi
                if(\App\Helpers\AppHelper::isEquals($type->name, "Transportasi")){
                    $temp->cost = $totalReimburse;
                }

                // Hari Raya

                // Uang Makan
                if(\App\Helpers\AppHelper::isEquals($type->name, "Uang Makan")){
                    $temp->cost = $temp->cost * $totalTravelDays;
                }

                $allowances[] = array(
                    "id"=>$type->id,
                    "name"=>$type->name,
                    "employee_id"=>$id,
                    "type_id"=>$type->id,
                    "cost"=> $temp ? $temp->cost : 0,
                    "is_active"=> $temp ? $temp->is_active : 0
                );

                $totalAllowances += $temp ? $temp->cost : 0;

            }
          
            
        }
        $items["allowances"] = $allowances;
        $items["totalAllowances"] = $totalAllowances;

        // Cuts
        $cut_types = LossType::orderBy("name", "ASC")->get();
        $cuts = array();
        foreach($cut_types as $type){
            $temp = EmployeeCut::where("employee_id", $id)->where("type_id", $type->id)->first();
            if(!is_null($temp)){
                
                if(\App\Helpers\AppHelper::isEquals($type->name, "Potongan Kehadiran")){
                    $temp->cost = $temp->cost * ($totalAnnual + $totalAbsenceByDaysLeave);
                }

                $cuts[] = array(
                    "id"=>$type->id,
                    "name"=>$type->name,
                    "employee_id"=>$id,
                    "type_id"=>$type->id,
                    "cost"=> $temp ? $temp->cost : 0,
                    "is_active"=> $temp ? $temp->is_active : 0
                );

                $totalCuts += $temp ? $temp->cost : 0;

            }
           
        }
        $items["status"] = EmployeePayroll::where("employee_id", $id)->where("month", $month)->where("year", $year)->count() > 0 ? 1 : 0;
        $items["totalDays"] = $totaldays;
        $items["totalhours"] = $totalhours;
        $items["totalAbsenceByDays"] = $totalAbsenceByDays;
        $items["totalAbsenceByDaysLeave"] = $totalAbsenceByDaysLeave;
        $items["totalAbsenceByHours"] = $totalAbsenceByHours;
        $items["cuts"] = $cuts;
        $items["totalCuts"] = $totalCuts;
        $items["takeHome"] = ($employee->Position->month_salary + $totalAllowances) - $totalCuts;
        $items["data"] = $employee;
        $items["month"]  = $month;
        $items["year"] = $year;
        $items["metaPermission"] = $this->metaPermission();
        $items["month_name"] = \App\Helpers\AppHelper::getMonth($month);
        return $items;
    }

}