<?php

namespace App\Models\Employees;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;
use App\Models\Core\Regency;
use App\Models\Core\Country;
use Illuminate\Support\Facades\DB;

class EmployeeTravel  extends MyModel{

    private $employeeId, $managerId, $mode;
    protected $table = 'employee_travel';
    protected $fillable = [
        "country_id",
        "regency_id",
        "employee_id",
        "manager_id",
        "request_date",
        "start_date",
        "end_date",
        "reason",
        "employee_notes",
        "manager_notes",
        "destination",
        "is_approved",
        "is_paid",
        "is_reimbursed",
        "cost"
    ];

    public function datatableConfig(){
        if((int) $this->getMode() == 0){
            return [
                "column"=> array(
                    "employee_travel.id",
                    "employee_travel.destination",
                    "employee_travel.request_date",
                    "employee_travel.start_date",
                    "employee_travel.end_date",
                    "employee_travel.is_approved",
                    "employee_travel.created_at",
                    "employee_travel.employee_id",
                    "employee_travel.manager_id",
                    "employee_travel.reason",
                    "employee_divisions.name as division_name",
                    "employee_positions.name as position_name",
                    "provinces.name as province_name",
                    "regencies.name as regency_name",
                    "countries.name as country_name",
                    "employee_travel.cost"
                ),
                "filter"=> array(
                    "employee_travel.id",
                    "employee_travel.destination",
                    "employee_travel.request_date",
                    "employee_travel.start_date",
                    "employee_travel.end_date",
                    "employee_travel.reason",
                    "employee_travel.is_approved",
                    "employee_travel.created_at"
                ),
            ];
        }else{
            return [
                "column"=> array(
                    "employee_travel.id",
                    "employee_staff.employee_number",
                    DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as employee_name"),
                    "employee_travel.destination",
                    "employee_travel.request_date",
                    "employee_travel.start_date",
                    "employee_travel.end_date",
                    "employee_travel.is_approved",
                    "employee_travel.created_at",
                    "employee_travel.employee_id",
                    "employee_travel.manager_id",
                    "employee_travel.reason",
                    "employee_divisions.name as division_name",
                    "employee_positions.name as position_name",
                    "provinces.name as province_name",
                    "regencies.name as regency_name",
                    "countries.name as country_name",
                    "employee_travel.cost"
                ),
                "filter"=> array(
                    "employee_travel.id",
                    "employee_staff.employee_number",
                    "profile_staff.first_name",
                    "employee_travel.destination",
                    "employee_travel.request_date",
                    "employee_travel.start_date",
                    "employee_travel.end_date",
                    "employee_travel.reason",
                    "employee_travel.is_approved",
                    "employee_travel.created_at"
                ),
            ];
        }
       
    }

    public function exportDataColumn(){
        return [
            "employee_staff.employee_number as NO_PEGAWAI",
            "employee_travel.destination AS DESTINASI",
            "employee_travel.request_date as TANGGAL_PERMOHONAN_DINAS",
            "employee_travel.start_date as TANGGAL_AWAL_DINAS",
            "employee_travel.end_date as TANGGAL_AKHIR_DINAS",
            "employee_travel.reason AS KETERANGAN",
            DB::raw("(CASE WHEN employee_travel.is_approved = 1 THEN 'Di setujui' WHEN employee_travel.is_approved = 2 THEN 'Di Tolak' ELSE 'Menunggu Persetujuan' END) AS STATUS"),
        ];
    }

    public function Manager() {
        return $this->belongsTo(Employee::class, "manager_id");
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, "employee_id");
    }

    public function Regency() {
        return $this->belongsTo(Regency::class, "regency_id");
    }

    public function Country() {
        return $this->belongsTo(Country::class, "country_id");
    }

    protected function onJoin($db){
        $db->leftJoin('employees as employee_staff', function($join) {
            $join->on('employee_staff.id', '=', 'employee_travel.employee_id');
        });
        $db->leftJoin('users_profile as profile_staff', function($join) {
            $join->on('profile_staff.user_id', '=', 'employee_staff.user_id');
        });
        $db->leftJoin('regencies', function($join) {
            $join->on('regencies.id', '=', 'employee_travel.regency_id');
        });
        $db->leftJoin('provinces', function($join) {
            $join->on('provinces.id', '=', 'regencies.province_id');
        });
        $db->leftJoin('countries', function($join) {
            $join->on('countries.id', '=', 'employee_travel.country_id');
        });
        $db->leftJoin('employees as employee_manager', function($join) {
            $join->on('employee_manager.id', '=', 'employee_travel.manager_id');
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
            $db->where("employee_travel.employee_id", $this->getEmployeeId());
        }else{
            $db->where("employee_travel.manager_id", $this->getEmployeeId());
            $db->where("employee_travel.is_approved", 0);
        }
    }

    public static function getTotalDaysByEmployee($month, $year, $id){
        $sql = "
            SELECT IFNULL(SUM(DAY(end_date)) - SUM(DAY(start_date)), 0) as total_days
            FROM employee_travel
            WHERE employee_id = ".$id." 
            AND is_approved = 1
            AND MONTH(request_date) = ".$month."
            AND YEAR(request_date) = ".$year."
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));
        $data =  DB::select($query);
        return isset($data[0]->total_days) ? $data[0]->total_days : 0;
    }

    public static function getReimburse($month, $year, $id){
        $sql = "
            SELECT IFNULL(SUM(cost),0) as total_reimburse
            FROM employee_travel 
            WHERE employee_id = ".$id." 
            AND is_approved = 1
            AND MONTH(request_date) = ".$month."
            AND YEAR(request_date) = ".$year."
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));
        $data =  DB::select($query);
        return isset($data[0]->total_reimburse) ? $data[0]->total_reimburse : 0;
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