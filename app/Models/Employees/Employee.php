<?php

namespace App\Models\Employees;

use App\Core\Models\MyModel;
use Illuminate\Support\Facades\DB;
// Relation
use App\Models\Organization\Division;
use App\Models\Organization\Position;
use App\Models\Master\EmployeeType;
use App\Models\Master\Job;
use App\Models\Auth\User;
use App\Models\Employees\EmployeeAnnual;
use App\Models\Employees\EmployeeOverTime;
use App\Models\Employees\EmployeeLoan;
use App\Models\Employees\EmployeeTravel;
use App\Models\Employees\EmployeeMutation;
use App\Models\Employees\EmployeePromotion;
use App\Models\Employees\EmployeeRetired;
use App\Models\Employees\EmployeeAllowance;
use App\Models\Employees\EmployeeCut;
use App\Models\Employees\EmployeePayroll;
use App\Models\Recruitment\Acceptance;

class Employee extends MyModel{

    protected $table = 'employees';
    protected $fillable = [
        "user_id",
        "job_id",
        "type_id",
        "position_id",
        "division_id",
        "employee_number",
        "join_date",
        "start_contract_date",
        "end_contract_date",
        "resign_date",
        "is_banned",
        "is_blacklist",
        "token",
        "finger_print",
        "rank",
        "weight",
        "height",
        "use_lens",
        "retirement",
    ];

    public function Job(){
        return $this->belongsTo(Job::class, "job_id");
    }

    public function Division(){
        return $this->belongsTo(Division::class, "division_id");
    }

    public function Position(){
        return $this->belongsTo(Position::class, "position_id");
    }

    public function EmployeeType(){
        return $this->belongsTo(EmployeeType::class, "type_id");
    }

    public function User(){
        return $this->belongsTo(User::class, "user_id");
    }

    public function EmployeeAllowance() {
        return $this->hasMany(EmployeeAllowance::class);
    }

    public function EmployeeCut() {
        return $this->hasMany(EmployeeCut::class);
    }

    public static function createNumber($position_id, $division_id){
        $current = self::where("position_id", $position_id)
            ->where("division_id", $division_id)
            ->where("join_date",">=",date("Y-01-01"))
            ->where("join_date","<=",date("Y-12-31"))
            ->count();
        $employee_number = array();
        $employee_number[] = date("y");
        $employee_number[] = \App\Helpers\AppHelper::indexToNumber($position_id, 4);
        $employee_number[] = \App\Helpers\AppHelper::indexToNumber($division_id, 4);
        $employee_number[] = \App\Helpers\AppHelper::indexToNumber((int)$current + 1, 4);
        return implode(null, $employee_number);
    }

    public function datatableConfig(){
        return [
            "column"=> array(
                "employees.id",
                "employees.employee_number",
                DB::raw("CONCAT(first_name,' ',IFNULL(last_name,'')) as employee_name"),
                "users.username",
                "users.email",
                "employee_divisions.name as division_name",
                "employee_positions.name as position_name",
                "employee_type.name as type_name",
                "employees.join_date",
                "employees.created_at",
                DB::raw("(SELECT count(*) FROM employee_allowances WHERE employee_allowances.employee_id = employees.id AND employee_allowances.cost > 0) AS allowances"),
                DB::raw("(SELECT count(*) FROM employee_cuts WHERE employee_cuts.employee_id = employees.id AND employee_cuts.cost > 0) AS cuts")
            ),
            "filter"=> array(
                "employees.id",
                "employees.employee_number",
                "users_profile.first_name",
                "users.username",
                "users.email",
                "employee_divisions.name",
                "employee_positions.name",
                "employee_type.name",
                "employees.created_at",
                "employees.created_at"
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            "employees.employee_number AS NIK",
            DB::raw("CONCAT(first_name,' ',IFNULL(last_name,'')) as NAMA_KARYAWAN"),
            "users.username AS USERNAME",
            "users.email AS EMAIL",
            "employee_divisions.name AS DIVISI",
            "employee_positions.name AS POSISI",
            "employee_type.name AS TIPE_KARYAWAN",
            "employee_jobs.name AS PROFESI",
            "employees.join_date AS TANGGAL_GABUNG",
            DB::raw("IFNULL(employees.start_contract_date,'-') AS TANGGAL_AWAL_KONTRAK"),
            DB::raw("IFNULL(employees.end_contract_date,'-') AS TANGGAL_AKHIR_KONTRAK"),
            DB::raw("IFNULL(employees.resign_date,'-') AS TANGGAL_RESIGN"),
            DB::raw("(CASE WHEN employees.is_banned = 1 THEN 'Ya' Else 'Tidak' END) AS BANNED"),
            DB::raw("(CASE WHEN employees.is_blacklist = 1 THEN 'Ya' Else 'Tidak' END) AS BLACKLIST"),
        ];
    }

    public function exportData(){
        $table = $this->TableName();
        $column = $this->exportDataColumn();
        $data = self::select($column)->where($table.".id","<>", 0);
        $data->orderBy("division_id","ASC");
        $data->orderBy("position_id","ASC");
        $data->orderBy("type_id","ASC");
        $this->onWhere($data);
        $this->onJoin($data);
        return $data->get()->toArray();
    }

    protected function onJoin($db){
        $db->Leftjoin('users', function($join) {
            $join->on('users.id', '=', 'employees.user_id');
        });
        $db->Leftjoin('users_profile', function($join) {
            $join->on('users_profile.user_id', '=', 'employees.user_id');
        });
        $db->Leftjoin('employee_divisions', function($join) {
            $join->on('employee_divisions.id', '=', 'employees.division_id');
        });
        $db->Leftjoin('employee_positions', function($join) {
            $join->on('employee_positions.id', '=', 'employees.position_id');
        });
        $db->Leftjoin('employee_type', function($join) {
            $join->on('employee_type.id', '=', 'employees.type_id');
        });
        $db->Leftjoin('employee_jobs', function($join) {
            $join->on('employee_jobs.id', '=', 'employees.job_id');
        });
        $db->Leftjoin('users_marital_status', function($join) {
            $join->on('users_marital_status.id', '=', 'users_profile.status_id');
        });
        $db->Leftjoin('users_genders', function($join) {
            $join->on('users_genders.id', '=', 'users_profile.gender_id');
        });
    }

    public function EmployeeAnnual() {
        return $this->hasMany(EmployeeAnnual::class);
    }

    public function EmployeeOverTime() {
        return $this->hasMany(EmployeeOverTime::class);
    }

    public function EmployeeLoan() {
        return $this->hasMany(EmployeeLoan::class);
    }

    public function EmployeeTravel(){
        return $this->hasMany(EmployeeTravel::class);
    }

    public function EmployeeMutation(){
        return $this->hasMany(EmployeeMutation::class);
    }

    public function EmployeePromotion() {
        return $this->hasMany(EmployeePromotion::class);
    }

    public function EmployeeRetired() {
        return $this->hasMany(EmployeeRetired::class);
    }

    public function Acceptance() {
        return $this->hasMany(Acceptance::class);
    }

    public function EmployeePayroll() {
        return $this->hasMany(EmployeePayroll::class);
    }

}