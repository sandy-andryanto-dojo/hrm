<?php

namespace App\Models\Employees;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;
use Illuminate\Support\Facades\DB;

class EmployeeRetired extends MyModel{

    protected $table = 'employee_retired';
    protected $fillable = [
        "employee_id",
        "manager_id",
        "date_retired",
        "reason",
        "employee_notes",
        "manager_notes",
        "is_approved"
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                "employee_retired.id",
                "employee_retired.employee_id",
                "employee_retired.manager_id",
                "employee_retired.date_retired",
                "employee_retired.reason",
                "employee_retired.employee_notes",
                "employee_retired.manager_notes",
                "employee_retired.is_approved",
                "employee_retired.created_at",
                // Relation
                "employee_staff.employee_number",
                DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as employee_name"),
                DB::raw("CONCAT(profile_manager.first_name,' ',profile_manager.last_name) as manager_name"),
            
            ),
            "filter"=> array(
                "employee_retired.id",
                "employee_staff.employee_number",
                "profile_staff.first_name",
                "employee_retired.date_retired",
                "profile_manager.first_name",
                "employee_retired.reason",
                "employee_retired.is_approved",
                "employee_retired.created_at",
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            "employee_staff.employee_number AS NO_PEGAWAI",
            DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as NAMA_GEGAWAI"),
            DB::raw("CONCAT(profile_manager.first_name,' ',profile_manager.last_name) as NAMA_ATASAN"),
            "employee_retired.date_retired AS TANGGAL_PENSIUN",
            DB::raw("(CASE WHEN employee_retired.is_approved = 1 THEN 'Di setujui' WHEN employee_retired.is_approved = 2 THEN 'Di Tolak' ELSE 'Menunggu Persetujuan' END) AS STATUS"),   
        ];
    }

    protected function onJoin($db){
        $db->join('employees as employee_staff', function($join) {
            $join->on('employee_staff.id', '=', 'employee_retired.employee_id');
        });
        $db->join('users_profile as profile_staff', function($join) {
            $join->on('profile_staff.user_id', '=', 'employee_staff.user_id');
        });
        $db->leftJoin('employees as employee_manager', function($join) {
            $join->on('employee_manager.id', '=', 'employee_retired.manager_id');
        });
        $db->leftJoin('users_profile as profile_manager', function($join) {
            $join->on('profile_manager.user_id', '=', 'employee_manager.user_id');
        });
       
    }

    public function Manager() {
        return $this->belongsTo(Employee::class, "manager_id");
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, "employee_id");
    }
    

    protected function onWhere($db){
        if(\Auth::Check()){
            $isAdmin = \Auth::User()->isAdmin();
            if($isAdmin == false){
                $employee_id = \Auth::User()->getEmployeeId();
                $db->where("employee_retired.manager_id", $employee_id);
                $db->where("employee_retired.is_approved", 0);
            }
        }
    }
    
}