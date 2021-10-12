<?php

namespace App\Models\Employees;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;

use Illuminate\Support\Facades\DB;

class EmployeeLoan  extends MyModel{

    private $employeeId, $managerId, $mode;

    protected $table = 'employee_loan';
    protected $fillable = [
        "employee_id",
        "manager_id",
        "reason",
        "employee_notes",
        "manager_notes",
        "is_approved",
        "is_paid",
        "cost"
    ];

    public function datatableConfig(){

        if((int) $this->getMode() == 0){
            return [
                "column"=> array(
                    "employee_loan.id",
                    "employee_loan.is_approved",
                    "employee_loan.created_at",
                    "employee_loan.employee_id",
                    "employee_loan.manager_id",
                    "employee_loan.reason",
                    "employee_divisions.name as division_name",
                    "employee_positions.name as position_name",
                    "employee_loan.cost",
                    "employee_loan.is_paid",
                ),
                "filter"=> array(
                    "employee_loan.id",
                    "employee_loan.cost",
                    "employee_loan.reason",
                    "employee_loan.is_approved",
                    "employee_loan.created_at",
                ),
            ];
        }else{
            return [
                "column"=> array(
                    "employee_loan.id",
                    "employee_staff.employee_number",
                    DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as employee_name"),
                    DB::raw("CONCAT(profile_manager.first_name,' ',profile_manager.last_name) as manager_name"),
                    "employee_loan.is_approved",
                    "employee_loan.created_at",
                    "employee_loan.employee_id",
                    "employee_loan.manager_id",
                    "employee_loan.reason",
                    "employee_divisions.name as division_name",
                    "employee_positions.name as position_name",
                    "employee_loan.cost",
                    "employee_loan.is_paid",
                ),
                "filter"=> array(
                    "employee_loan.id",
                    "employee_staff.employee_number",
                    "profile_staff.first_name",
                    "employee_loan.cost",
                    "employee_loan.is_approved",
                    "employee_loan.created_at",
                ),
            ];
        }

        
    }

    public function exportDataColumn(){
        return [
            DB::raw("(CASE WHEN employee_loan.cost IS NULL THEN 0 ELSE FORMAT(employee_loan.cost, 2) END) AS TOTAL"),
            "employee_loan.reason as ALASAN",
            DB::raw("(CASE WHEN employee_loan.is_approved = 1 THEN 'Di setujui' WHEN employee_loan.is_approved = 2 THEN 'Di Tolak' ELSE 'Menunggu Persetujuan' END) AS STATUS"),
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
            $join->on('employee_staff.id', '=', 'employee_loan.employee_id');
        });
        $db->join('users_profile as profile_staff', function($join) {
            $join->on('profile_staff.user_id', '=', 'employee_staff.user_id');
        });
        $db->leftJoin('employees as employee_manager', function($join) {
            $join->on('employee_manager.id', '=', 'employee_loan.manager_id');
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
            $db->where("employee_loan.employee_id", $this->getEmployeeId());
        }else{
            $db->where("employee_loan.manager_id", $this->getEmployeeId());
            $db->where("employee_loan.is_approved", 0);
        }
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