<?php

namespace App\Models\Employees;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;
use App\Models\Organization\Division;
use Illuminate\Support\Facades\DB;

class EmployeeMutation extends MyModel{

    protected $table = 'employee_mutations';
    protected $fillable = [
        "employee_id",
        "manager_id",
        "division_from_id",
        "division_target_id",
        "reason",
        "employee_notes",
        "manager_notes",
        "is_approved"
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                "employee_mutations.id",
                "employee_mutations.employee_id",
                "employee_mutations.manager_id",
                "employee_mutations.division_from_id",
                "employee_mutations.division_target_id",
                "employee_mutations.reason",
                "employee_mutations.employee_notes",
                "employee_mutations.manager_notes",
                "employee_mutations.is_approved",
                "employee_mutations.created_at",
                // Relation
                "employee_staff.employee_number",
                DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as employee_name"),
                DB::raw("CONCAT(profile_manager.first_name,' ',profile_manager.last_name) as manager_name"),
                "division_from.name as division_from_name",
                "division_target.name as division_target_name"
            ),
            "filter"=> array(
                "employee_mutations.id",
                "employee_staff.employee_number",
                "profile_staff.first_name",
                "division_from.name",
                "division_target.name",
                "profile_manager.first_name",
                "employee_mutations.reason",
                "employee_mutations.is_approved",
                "employee_mutations.created_at",
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            "employee_staff.employee_number AS NO_PEGAWAI",
            DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as NAMA_GEGAWAI"),
            DB::raw("CONCAT(profile_manager.first_name,' ',profile_manager.last_name) as NAMA_ATASAN"),
            "division_from.name AS DIVISI_ASAL",
            "division_target.name AS DIVISI_TUJUAN",
            "employee_mutations.created_at AS TANGGAL_MUTASI",
            DB::raw("(CASE WHEN employee_mutations.is_approved = 1 THEN 'Di setujui' WHEN employee_mutations.is_approved = 2 THEN 'Di Tolak' ELSE 'Menunggu Persetujuan' END) AS STATUS"),   
        ];
    }

    protected function onJoin($db){
        $db->join('employees as employee_staff', function($join) {
            $join->on('employee_staff.id', '=', 'employee_mutations.employee_id');
        });
        $db->join('users_profile as profile_staff', function($join) {
            $join->on('profile_staff.user_id', '=', 'employee_staff.user_id');
        });
        $db->leftJoin('employees as employee_manager', function($join) {
            $join->on('employee_manager.id', '=', 'employee_mutations.manager_id');
        });
        $db->leftJoin('users_profile as profile_manager', function($join) {
            $join->on('profile_manager.user_id', '=', 'employee_manager.user_id');
        });
        $db->Leftjoin('employee_divisions as division_from', function($join) {
            $join->on('division_from.id', '=', 'employee_mutations.division_from_id');
        });
        $db->Leftjoin('employee_divisions as division_target', function($join) {
            $join->on('division_target.id', '=', 'employee_mutations.division_target_id');
        });
    }

    public function Manager() {
        return $this->belongsTo(Employee::class, "manager_id");
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, "employee_id");
    }

    public function DivisionFrom() {
        return $this->belongsTo(Division::class, "division_from_id");
    }

    public function DivisionTarget() {
        return $this->belongsTo(Division::class, "division_target_id");
    }

    protected function onWhere($db){
        if(\Auth::Check()){
            $isAdmin = \Auth::User()->isAdmin();
            if($isAdmin == false){
                $employee_id = \Auth::User()->getEmployeeId();
                $db->where("employee_mutations.manager_id", $employee_id);
                $db->where("employee_mutations.is_approved", 0);
            }
        }
    }
    
}