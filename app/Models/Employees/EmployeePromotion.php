<?php

namespace App\Models\Employees;

use App\Core\Models\MyModel;
use App\Models\Employees\Employee;
use App\Models\Organization\Position;
use Illuminate\Support\Facades\DB;

class EmployeePromotion extends MyModel{

    protected $table = 'employee_promotions';
    protected $fillable = [
        "employee_id",
        "manager_id",
        "position_from_id",
        "position_target_id",
        "reason",
        "employee_notes",
        "manager_notes",
        "is_approved"
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                "employee_promotions.id",
                "employee_promotions.employee_id",
                "employee_promotions.manager_id",
                "employee_promotions.position_from_id",
                "employee_promotions.position_target_id",
                "employee_promotions.reason",
                "employee_promotions.employee_notes",
                "employee_promotions.manager_notes",
                "employee_promotions.is_approved",
                "employee_promotions.created_at",
                // Relation
                "employee_staff.employee_number",
                DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as employee_name"),
                DB::raw("CONCAT(profile_manager.first_name,' ',profile_manager.last_name) as manager_name"),
                "position_from.name as position_from_name",
                "position_target.name as position_target_name"
            ),
            "filter"=> array(
                "employee_promotions.id",
                "employee_staff.employee_number",
                "profile_staff.first_name",
                "position_from.name",
                "position_target.name",
                "profile_manager.first_name",
                "employee_promotions.reason",
                "employee_promotions.is_approved",
                "employee_promotions.created_at",
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            "employee_staff.employee_number AS NO_PEGAWAI",
            DB::raw("CONCAT(profile_staff.first_name,' ',profile_staff.last_name) as NAMA_GEGAWAI"),
            DB::raw("CONCAT(profile_manager.first_name,' ',profile_manager.last_name) as NAMA_ATASAN"),
            "position_from.name AS POSISI_SEKARANG",
            "position_target.name AS POSISI_TUJUAN",
            "employee_promotions.created_at AS TANGGAL_MUTASI",
            DB::raw("(CASE WHEN employee_promotions.is_approved = 1 THEN 'Di setujui' WHEN employee_promotions.is_approved = 2 THEN 'Di Tolak' ELSE 'Menunggu Persetujuan' END) AS STATUS"),   
        ];
    }

    protected function onJoin($db){
        $db->join('employees as employee_staff', function($join) {
            $join->on('employee_staff.id', '=', 'employee_promotions.employee_id');
        });
        $db->join('users_profile as profile_staff', function($join) {
            $join->on('profile_staff.user_id', '=', 'employee_staff.user_id');
        });
        $db->leftJoin('employees as employee_manager', function($join) {
            $join->on('employee_manager.id', '=', 'employee_promotions.manager_id');
        });
        $db->leftJoin('users_profile as profile_manager', function($join) {
            $join->on('profile_manager.user_id', '=', 'employee_manager.user_id');
        });
        $db->Leftjoin('employee_positions as position_from', function($join) {
            $join->on('position_from.id', '=', 'employee_promotions.position_from_id');
        });
        $db->Leftjoin('employee_positions as position_target', function($join) {
            $join->on('position_target.id', '=', 'employee_promotions.position_target_id');
        });
    }

    public function Manager() {
        return $this->belongsTo(Employee::class, "manager_id");
    }

    public function Employee() {
        return $this->belongsTo(Employee::class, "employee_id");
    }

    public function PositionFrom() {
        return $this->belongsTo(Position::class, "position_from_id");
    }

    public function PositionTarget() {
        return $this->belongsTo(Position::class, "position_target_id");
    }

    protected function onWhere($db){
        if(\Auth::Check()){
            $isAdmin = \Auth::User()->isAdmin();
            if($isAdmin == false){
                $employee_id = \Auth::User()->getEmployeeId();
                $db->where("employee_promotions.manager_id", $employee_id);
                $db->where("employee_promotions.is_approved", 0);
            }
        }
    }
    
}