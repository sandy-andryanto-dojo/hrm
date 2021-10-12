<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\DataTableRequest;
use App\Models\Employees\Employee;
use DB;


class EmployeeAbsence extends Model{

    public $timestamps = true;
    protected $table = 'employee_absence';
    protected $fillable = [
        "absence_date",
        "employee_id",
        "start_hour",
        "end_hour",
        "total",
        "month",
        "year",
        "status",
        "notes",
        "is_holiday",
        "is_aprroved"
    ];
    

    public function datatableByMonthYear(DataTableRequest $request, $month, $year){

        $superior_id = \Auth::User()->id;
        
        $filter = [
            'employees.id', 
            'employees.employee_number',
            'users_profile.first_name',
            'employee_divisions.name',
            'employee_positions.name',
            'employees.created_at',
            'employees.created_at',
        ];

        $search = $request->getSearch();
        $sort = [$request->getSortColumnIndex(), $request->getSortDirection()];
        $limit = $request->getDisplayLength();
        $offset = $request->getDisplayStart();

        $eid = self::distinct("employee_absence.employee_id")
            ->join("employees","employees.id","=","employee_absence.employee_id")
            ->join("employee_divisions","employee_divisions.id", "=", "employees.division_id")
            ->where("employee_absence.month", $month)
            ->where("employee_absence.year", $year)
            ->where("employee_divisions.superior_id", $superior_id)
            ->where("employee_absence.is_aprroved", 0)
            ->where("employee_absence.status","!=", 0)
            ->pluck("employee_absence.employee_id")
            ->toArray();

    
        $employee =  DB::table("employees")
            ->select([
                DB::raw("employees.id as employee_id"),
                DB::raw("employee_divisions.superior_id as superior_id"),
                DB::raw("employees.employee_number as nik"),
                DB::raw("CONCAT(users_profile.first_name,' ',IFNULL(users_profile.last_name,'')) as employee_name"),
                DB::raw("employee_divisions.name as division_name"),
                DB::raw("employee_positions.name as position_name"),
                DB::raw("(SELECT IFNULL(SUM(total), 0) FROM employee_absence WHERE employee_absence.employee_id = employees.id AND employee_absence.month = ".$month." AND employee_absence.year = ".$year.") as total_absence")
            ])
            ->whereIn("employees.id", $eid)
            ->where("employee_divisions.superior_id", $superior_id)
            ->join("users_profile","users_profile.user_id", "=", "employees.user_id")
            ->join("employee_divisions","employee_divisions.id", "=", "employees.division_id")
            ->join("employee_positions","employee_positions.id", "=", "employees.position_id");
       
        $total_data = $employee->count();

        if ($search != '') {
            $employee->where(function($q) use ($search, $filter) {
                for ($i = 0; $i < count($filter); $i++) {
                    if (isset($filter[$i])) {
                        if ($i == 0) {
                            $q->Where($filter[$i], 'like', '%' . $search . '%');
                        } else {
                            $q->orWhere($filter[$i], 'like', '%' . $search . '%');
                        }
                    }
                }
            });
        }      
      
        $total_filtered = $employee->count();
        $employee->skip($offset)->take($limit);        
        return array(
            "sEcho" => $request->getEcho(),
            "iTotalRecords" => intval($total_data),
            "iTotalDisplayRecords" => intval($total_filtered),
            "aaData" => $employee->get(),
            "sort"=>$sort
        );        

    }

    public function syncAbsence(array $data){
        $employee_id = $data["employee_id"];
        $month = $data["month"];
        $year = $data["year"];
        $absence_date = $data["absence_date"]; // array
        $start_hour = $data["start_hour"]; // array
        $end_hour = $data["end_hour"]; // array
        $is_holiday = $data["is_holiday"]; // array
        $status = $data["status"]; // array
        $notes = $data["notes"]; // array
        $total = $data["total"]; // array

        DB::beginTransaction();
        try{
            self::where("employee_id", $employee_id)->where("month", $month)->where("year", $year)->delete();
            for($i = 0; $i < count($absence_date); $i++){
                self::create([
                    "absence_date"=> isset($absence_date[$i]) ? $absence_date[$i] : null,
                    "employee_id"=>$employee_id,
                    "start_hour"=> isset($start_hour[$i]) ? $start_hour[$i] : null,
                    "end_hour"=> isset($end_hour[$i]) ? $end_hour[$i] : null,
                    "total"=> isset($total[$i]) ? $total[$i] : 0,
                    "month"=>$month,
                    "year"=>$year,
                    "status"=> isset($status[$i]) ? $status[$i] : 0,
                    "notes"=> isset($notes[$i]) ? $notes[$i] : null,
                    "is_holiday"=> isset($is_holiday[$i]) ? $is_holiday[$i] : 0,
                    "is_aprroved"=>0
                ]);
            }
            DB::commit();
            return TRUE;

        }catch(Exception  $e){
            DB::rollback();
            throw $e;
        }

        return FALSE;
    } 
   
    public function approve($month, $year, $employee_id){
        $_sql = "UPDATE employee_absence SET is_aprroved = 1 WHERE month = ".$month." AND year = ".$year." AND employee_id = ".$employee_id;
        $sql = trim(preg_replace('/\s+/', ' ', $_sql));
        $result = DB::statement(DB::raw($sql));
        return $result;
    }

    public static function getTotalDays($month, $year, $id){
        $sql = "
            SELECT DISTINCT COUNT(absence_date) as total_days
            FROM employee_absence WHERE MONTH(absence_date) = ".$month."
            AND YEAR(absence_date) = ".$year."
            AND is_holiday = 0
            AND employee_id = ".$id." 
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));
        $data =  DB::select($query);
        return isset($data[0]->total_days) ? $data[0]->total_days : 0;
    }

    public static function getTotalHours($month, $year, $id){
        $days = self::getTotalDays($month, $year, $id);
        return $days * 8;
    }

    public static function getTotalDaysByEmployee($month, $year, $id, $leave = false){
        $totalWhere = $leave ? "= 0" : "> 0";
        $sql = "
            SELECT COUNT(*) as total_days
            FROM employee_absence
            WHERE employee_id = ".$id." 
            AND is_aprroved = 1
            AND total ".$totalWhere."
            AND is_holiday = 0
            AND MONTH(absence_date) = ".$month."
            AND YEAR(absence_date) = ".$year."
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));
        $data =  DB::select($query);
        return isset($data[0]->total_days) ? $data[0]->total_days : 0;
    }

    public static function getTotalHoursByEmployee($month, $year, $id){
        $sql = "
            SELECT IFNULL(SUM(total),0) as total_hours
            FROM employee_absence 
            WHERE employee_id = ".$id." 
            AND is_aprroved = 1
            AND is_holiday = 0
            AND MONTH(absence_date) = ".$month."
            AND YEAR(absence_date) = ".$year."
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));
        $data =  DB::select($query);
        return isset($data[0]->total_hours) ? $data[0]->total_hours : 0;
    }

}