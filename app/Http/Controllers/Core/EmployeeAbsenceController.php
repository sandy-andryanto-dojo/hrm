<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\EmployeeAbsence;
use App\Models\Employees\Employee;
use App\Models\Master\Holiday;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class EmployeeAbsenceController extends MyController{

    public function __construct(){
        $this->model = new EmployeeAbsence;
        $this->route = "employee_absences";
        $this->exportTitle = "DAFTAR_KEHADIRAN";
        $this->useCode = false;
    }

    public function index(){
        $month = (int) date("m");
        $year = (int) date("Y");
        return redirect()->route("employee_absences.current", ["month"=>$month, "year"=> $year]);
    }

    public function current($month, $year){
        $id = \Auth::User()->getEmployeeId();
        $user_id = \Auth::User()->id;
        $dates = array();
        $dt = Carbon::createFromDate($year, $month);
        $totalDays = $dt->daysInMonth;
        $approved = EmployeeAbsence::where("month", $month)
            ->where("year", $year)
            ->where("employee_id", $id)
            ->where("is_aprroved", 1)
            ->count();

        $pending = EmployeeAbsence::where("employee_absence.month", $month)
            ->groupBy(["employee_absence.employee_id","employee_absence.absence_date"])
            ->join("employees","employees.id","=","employee_absence.employee_id")
            ->join("employee_divisions","employee_divisions.id", "=", "employees.division_id")
            ->where("employee_absence.year", $year)
            ->where("employee_divisions.superior_id", $user_id)
            ->where("employee_absence.is_aprroved", 0)
            ->where("employee_absence.status",">", 0)
            ->count();

        for($i = 1; $i <= $totalDays; $i++){
            $_month = \App\Helpers\AppHelper::indexToNumber($month, 2);
            $_date = \App\Helpers\AppHelper::indexToNumber($i, 2);
            $_realDate = $year."-".$_month."-".$_date;
            $d = new \DateTime($_realDate);
            $absence = EmployeeAbsence::where("absence_date", $_realDate)->where("employee_id", $id)->first();
            if(!is_null($absence)){
                $absence->setAttribute("start_hour", Carbon::createFromFormat('H:i:s', $absence->start_hour)->format('H:i'));
                $absence->setAttribute("end_hour", Carbon::createFromFormat('H:i:s', $absence->end_hour)->format('H:i'));
            }
            $dates[] = array(
                "date"=>$_realDate,
                "absence"=>$absence,
                "day_name"=>strtolower($d->format('l')),
                "date_holiday"=> Holiday::where("date_holiday", $_realDate)->first()
            );
        }   

        $items = array(
            "month_name"=>\App\Helpers\AppHelper::getMonth($month),
            "month"=>$month, 
            "year"=>$year, 
            "employee_id"=>$id,
            "dates"=>$dates,
            "employee"=>Employee::findOrFail($id),
            "is_approved"=> intval($approved) > 0 ? true : false,
            "pending"=>$pending
        );
        $items["metaPermission"] = $this->metaPermission();
        return view('core.'.$this->route.'.index', $items);
    }

    public function detail($month, $year, $id){

        $dates = array();
        $dt = Carbon::createFromDate($year, $month);
        $totalDays = $dt->daysInMonth;
        $approved = EmployeeAbsence::where("month", $month)->where("year", $year)->where("employee_id", $id)->where("is_aprroved", 1)->count();
        for($i = 1; $i <= $totalDays; $i++){
            $_month = \App\Helpers\AppHelper::indexToNumber($month, 2);
            $_date = \App\Helpers\AppHelper::indexToNumber($i, 2);
            $_realDate = $year."-".$_month."-".$_date;
            $d = new \DateTime($_realDate);
            $absence = EmployeeAbsence::where("absence_date", $_realDate)->where("employee_id", $id)->first();
            if(!is_null($absence)){
                $absence->setAttribute("start_hour", Carbon::createFromFormat('H:i:s', $absence->start_hour)->format('H:i'));
                $absence->setAttribute("end_hour", Carbon::createFromFormat('H:i:s', $absence->end_hour)->format('H:i'));
            }
            $dates[] = array(
                "date"=>$_realDate,
                "absence"=>$absence,
                "day_name"=>strtolower($d->format('l')),
                "date_holiday"=> Holiday::where("date_holiday", $_realDate)->first()
            );
        }   

        $items = array(
            "month_name"=>\App\Helpers\AppHelper::getMonth($month),
            "month"=>$month, 
            "year"=>$year, 
            "employee_id"=>$id,
            "dates"=>$dates,
            "employee"=>Employee::findOrFail($id),
            "is_approved"=> intval($approved) > 0 ? true : false,
            "date_holiday"=> Holiday::where("date_holiday", $_realDate)->first()
        );
        $items["metaPermission"] = $this->metaPermission();
        return view('core.'.$this->route.'.show', $items);
    }

    public function modify($month, $year, $id){

        $approved = EmployeeAbsence::where("month", $month)->where("year", $year)->where("employee_id", $id)->where("is_aprroved", 1)->count();
        if($approved){
            return redirect()->route("employee_absences.detail", ["month"=>$month, "year"=>$year, "id"=>$employee_id]);
        }else{
            $dates = array();
            $dt = Carbon::createFromDate($year, $month);
            $totalDays = $dt->daysInMonth;
            for($i = 1; $i <= $totalDays; $i++){
                $_month = \App\Helpers\AppHelper::indexToNumber($month, 2);
                $_date = \App\Helpers\AppHelper::indexToNumber($i, 2);
                $_realDate = $year."-".$_month."-".$_date;
                $d = new \DateTime($_realDate);
                $absence = EmployeeAbsence::where("absence_date", $_realDate)->where("employee_id", $id)->first();
                if(!is_null($absence)){
                    $absence->setAttribute("start_hour", Carbon::createFromFormat('H:i:s', $absence->start_hour)->format('H:i'));
                    $absence->setAttribute("end_hour", Carbon::createFromFormat('H:i:s', $absence->end_hour)->format('H:i'));
                }
                $dates[] = array(
                    "date"=>$_realDate,
                    "absence"=>$absence,
                    "day_name"=>strtolower($d->format('l')),
                    "date_holiday"=> Holiday::where("date_holiday", $_realDate)->first()
                );
            }   

            $items = array(
                "month_name"=>\App\Helpers\AppHelper::getMonth($month),
                "month"=>$month, 
                "year"=>$year, 
                "employee_id"=>$id,
                "dates"=>$dates,
                "employee"=>Employee::findOrFail($id)
            );
            $items["metaPermission"] = $this->metaPermission();

            return view('core.'.$this->route.'.edit', $items);
        }

    }

    public function store(Request $request){
        $data = $request->all();
        $employee_id = $data["employee_id"];
        $month = $data["month"];
        $year = $data["year"];
        $message = "Absensi Periode <strong>".\App\Helpers\AppHelper::getMonth($month)." ".$year."</strong> berhasil diperbaharui .";
        $this->model->syncAbsence($data);


        $monthName = \App\Helpers\AppHelper::getMonth($month);
        $employee = \Auth::User()->getEmployee();
        $sender_id = \Auth::User()->id;
        $recevier_id = $employee->Division->superior_id ? $employee->Division->superior_id : null;
        $employeeName = \Auth::User()->UserProfile->first_name." ".\Auth::User()->UserProfile->last_name;
        $subject = "Konfirmasi Absenesi ";
        $notif = "Konfirmasi Absesnsi Pegawai : <b>".$employee->employee_number."  ".$employeeName."</b>";
        $notif .= "<br> Bulan ".$monthName." tahun ".$year;
        $link = route("employee_absences.detail", ["month"=>$month, "year"=>$year, "id"=>$employee_id]);
        \App\Helpers\AppHelper::sendNotif([
            "sender_id"=>$sender_id,
            "recevier_id"=>$recevier_id,
            "subject"=>$subject,
            "message"=>$notif,
            "link"=>$link
        ]);

        return redirect()->route("employee_absences.detail", ["month"=>$month, "year"=>$year, "id"=>$employee_id])->with('success', $message);
    }

    public function update(Request $request, $id){
        $data = $request->all();
        $employee_id = $data["employee_id"];
        $month = $data["month"];
        $year = $data["year"];
        $approve = $this->model->approve($month, $year, $employee_id);
        $employee = Employee::findOrFail($employee_id);
        $nama_lengkap = $employee->User ? $employee->User->UserProfile->first_name." ".$employee->User->UserProfile->last_name : "-";
        $nama_pegawai = $employee->employee_number." ".$nama_lengkap;
        $message = "Absensi pegawai atas nama <strong>".$nama_pegawai."</strong> Periode <strong>".\App\Helpers\AppHelper::getMonth($month)." ".$year."</strong> berhasil dikonfirmasi .";

        $monthName = \App\Helpers\AppHelper::getMonth($month);
        $sender_id = \Auth::User()->id;
        $recevier_id = $employee->user_id;
       
        $subject = "Konfirmasi Absenesi ";
        $notif = "Konfirmasi Absesnsi Pegawai : <b>".$employee->employee_number."  ".$nama_pegawai."</b>";
        $notif .= "<br> Bulan ".$monthName." tahun ".$year." , Berhasil disetujui.";
        $link = route("employee_absences.detail", ["month"=>$month, "year"=>$year, "id"=>$employee_id]);
        \App\Helpers\AppHelper::sendNotif([
            "sender_id"=>$sender_id,
            "recevier_id"=>$recevier_id,
            "subject"=>$subject,
            "message"=>$notif,
            "link"=>$link
        ]);


        return redirect()->route("employee_absences.current", ["month"=>$month, "year"=>$year])->with('success', $message);
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

    public function destroy($id){
        return abort(404);    
    }   
    
}