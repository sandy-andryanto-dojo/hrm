<?php

namespace App\Models\Employees;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeOverTime  extends MyModel{

    private $employeeId, $managerId, $mode;

    protected $table = 'employee_over_time';
    protected $fillable = [
        "employee_id",
        "manager_id",
        "request_date",
        "start_hour",
        "end_hour",
        "reason",
        "employee_notes",
        "manager_notes",
        "is_approved",
    ];

    public function datatableConfig(){
        if((int) $this->getMode() == 0){
            return [
                "column"=> array(
                    "employee_over_time.id",
                    "employee_over_time.request_date",
                    "employee_over_time.start_hour",
                    "employee_over_time.end_hour",
                    "employee_over_time.is_approved",
                    "employee_over_time.created_at",
                    "employee_over_time.employee_id",
                    "employee_over_time.manager_id",
                    "employee_over_time.reason",
                    "employee_divisions.name as division_name",
                    "employee_positions.name as position_name",
                ),
                "filter"=> array(
                    "employee_over_time.id",
                    "employee_over_time.request_date",
                    "employee_over_time.start_hour",
                    "employee_over_time.end_hour",
                    "employee_over_time.reason",
                    "employee_over_time.is_approved",
                    "employee_over_time.created_at"
                ),
            ];
        }else{
            return [
                "column"=> array(
                    "employee_over_time.id",
                    "employee_staff.employee_number",
                    DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as employee_name"),
                    "employee_over_time.request_date",
                    "employee_over_time.start_hour",
                    "employee_over_time.end_hour",
                    "employee_over_time.is_approved",
                    "employee_over_time.created_at",
                    "employee_over_time.employee_id",
                    "employee_over_time.manager_id",
                    "employee_over_time.reason",
                    "employee_divisions.name as division_name",
                    "employee_positions.name as position_name",
                ),
                "filter"=> array(
                    "employee_over_time.id",
                    "employee_staff.employee_number",
                    "profile_staff.first_name",
                    "employee_over_time.request_date",
                    "employee_over_time.start_hour",
                    "employee_over_time.end_hour",
                    "employee_over_time.reason",
                    "employee_over_time.is_approved",
                    "employee_over_time.created_at"
                ),
            ];
        }
        
    }

    public function exportDataColumn(){
        return [
            "employee_staff.employee_number as NO_PEGAWAI",
            "employee_over_time.request_date as TANGGAL_PERMOHONAN_CUTI",
            "employee_over_time.start_hour as WAKTU_MULAI",
            "employee_over_time.end_hour as WAKTU_AKHIR",
            "employee_over_time.reason as ALASAN",
            DB::raw("(CASE WHEN employee_over_time.is_approved = 1 THEN 'Di setujui' WHEN employee_over_time.is_approved = 2 THEN 'Di Tolak' ELSE 'Menunggu Persetujuan' END) AS STATUS"),
        ];
    }

    public function Manager() {
        return $this->belongsTo(Employee::class, "manager_id");
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, "employee_id");
    }

    protected function onJoin($db){
        $db->join('employees as employee_staff', function($join) {
            $join->on('employee_staff.id', '=', 'employee_over_time.employee_id');
        });
        $db->join('users_profile as profile_staff', function($join) {
            $join->on('profile_staff.user_id', '=', 'employee_staff.user_id');
        });
        $db->leftJoin('employees as employee_manager', function($join) {
            $join->on('employee_manager.id', '=', 'employee_over_time.manager_id');
        });
        $db->leftJoin('users_profile as profile_manager', function($join) {
            $join->on('profile_manager.user_id', '=', 'employee_manager.user_id');
        });
        $db->Leftjoin('employee_divisions', function($join) {
            $join->on('employee_divisions.id', '=', 'employee_staff.division_id');
        });
        $db->Leftjoin('employee_positions', function($join) {
            $join->on('employee_positions.id', '=', 'employee_staff.position_id');
        });
    }

    protected function onWhere($db){
        if((int) $this->getMode() == 0){
            $db->where("employee_over_time.employee_id", $this->getEmployeeId());
        }else{
            $db->where("employee_over_time.manager_id", $this->getEmployeeId());
            $db->where("employee_over_time.is_approved", 0);
        }   
        
    }

    public static function getTotalHoursByEmployee($month, $year, $id){
        $sql = "
            SELECT IFNULL((SUM(HOUR(end_hour)) - SUM(HOUR(start_hour))), 0) as total_hours
            FROM employee_over_time 
            WHERE employee_id = ".$id." 
            AND is_approved = 1
            AND MONTH(request_date) = ".$month."
            AND YEAR(request_date) = ".$year."
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));
        $data =  DB::select($query);
        return isset($data[0]->total_hours) ? $data[0]->total_hours : 0;
    }

    /**
     * Get the value of employeeId
     */ 
    public function getEmployeeId()
    {
        return $this->employeeId;
    }

    /**
     * Set the value of employeeId
     *
     * @return  self
     */ 
    public function setEmployeeId($employeeId)
    {
        $this->employeeId = $employeeId;

        return $this;
    }

    /**
     * Get the value of managerId
     */ 
    public function getManagerId()
    {
        return $this->managerId;
    }

    /**
     * Set the value of managerId
     *
     * @return  self
     */ 
    public function setManagerId($managerId)
    {
        $this->managerId = $managerId;

        return $this;
    }

    /**
     * Get the value of mode
     */ 
    public function getMode()
    {
        return $this->mode;
    }

    /**
     * Set the value of mode
     *
     * @return  self
     */ 
    public function setMode($mode)
    {
        $this->mode = $mode;

        return $this;
    }
    

}