<?php

namespace App\Models\Recruitment;

use Illuminate\Support\Facades\DB;
use App\Core\Models\MyModel;
// Relation
use App\Models\Master\Job;
use App\Models\Master\EmployeeType;
use App\Models\Organization\Division;
use App\Models\Organization\Position;
use App\Models\Recruitment\Acceptance;

class Vacancy extends MyModel{

    private $isAcceptance = false;

    protected $table = 'employee_vacancies';
    protected $fillable = [
        "name",
        "type_id",
        "job_id",
        "position_id",
        "division_id",
        "start_date",
        "end_date",
        "country_id",
        "description",
        "location",
        "info",
        "history",
        "profile",
        "min_salary",
        "max_salary",
        "is_closed"
    ];

    public function datatableConfig(){

        if($this->getIsAcceptance() == false){
            return [
                "column"=> array(
                    "employee_vacancies.id",
                    "employee_vacancies.name as vacancy_name",
                    "employee_vacancies.type_id",
                    "employee_vacancies.job_id",
                    "employee_vacancies.position_id",
                    "employee_vacancies.division_id",
                    "employee_vacancies.start_date",
                    "employee_vacancies.end_date",
                    "employee_vacancies.country_id",
                    "employee_vacancies.description",
                    "employee_vacancies.location",
                    "employee_vacancies.info",
                    "employee_vacancies.history",
                    "employee_vacancies.profile",
                    "employee_vacancies.min_salary",
                    "employee_vacancies.max_salary",
                    "employee_vacancies.is_closed",
                    // Relation
                    "employee_type.name as type_name",
                    "employee_jobs.name as job_name",
                    "employee_positions.name as position_name",
                    "employee_divisions.name as division_name",
                ),
                "filter"=> array(
                    "employee_vacancies.id",
                    "employee_vacancies.name",
                    "employee_type.name",
                    "employee_jobs.name",
                    "employee_positions.name",
                    "employee_divisions.name",
                    "employee_vacancies.start_date",
                    "employee_vacancies.end_date",
                    "employee_vacancies.created_at"
                ),
            ];
        }else{
            return [
                "column"=> array(
                    "employee_vacancies.id",
                    "employee_vacancies.name as vacancy_name",
                    "employee_vacancies.type_id",
                    "employee_vacancies.job_id",
                    "employee_vacancies.position_id",
                    "employee_vacancies.division_id",
                    "employee_vacancies.start_date",
                    "employee_vacancies.end_date",
                    "employee_vacancies.country_id",
                    "employee_vacancies.description",
                    "employee_vacancies.location",
                    "employee_vacancies.info",
                    "employee_vacancies.history",
                    "employee_vacancies.profile",
                    "employee_vacancies.min_salary",
                    "employee_vacancies.max_salary",
                    "employee_vacancies.is_closed",
                    // Relation
                    "employee_type.name as type_name",
                    "employee_jobs.name as job_name",
                    "employee_positions.name as position_name",
                    "employee_divisions.name as division_name",
                    DB::raw("IFNULL((SELECT COUNT(*) FROM employee_acceptance WHERE employee_acceptance.vacancy_id = employee_vacancies.id), 0) AS total_candidate")
                ),
                "filter"=> array(
                    "employee_vacancies.id",
                    "employee_vacancies.name",
                    "employee_type.name",
                    "employee_jobs.name",
                    "employee_positions.name",
                    "employee_divisions.name",
                    "employee_vacancies.start_date",
                    "employee_vacancies.end_date",
                    "employee_vacancies.is_closed",
                    "employee_vacancies.is_closed",
                    "employee_vacancies.created_at"
                ),
            ];
        }

      
    }

    public function exportDataColumn(){
        if($this->getIsAcceptance() == false){
            return [
                "employee_vacancies.name as NAMA_LOWONGAN",
                "employee_type.name AS TIPE_KARYAWAN",
                "employee_jobs.name AS PEKERJAAN",
                "employee_positions.name AS POSISI",
                "employee_divisions.name AS DIVISI",
                "employee_vacancies.start_date AS TANGGAL_LOWONGAN",
                "employee_vacancies.end_date AS TANGGAL_AKHIR",
                "employee_vacancies.description AS DESKRIPSI",
                "employee_vacancies.location AS LOKASI",
                DB::raw("FORMAT(employee_vacancies.min_salary, 2) AS GAJI_MINIMUM"),
                DB::raw("FORMAT(employee_vacancies.max_salary, 2) AS GAJI_MAKSIMAL"),
            ];
        }else{

        }
        
    }

    protected function onJoin($db){
        $db->leftJoin('employee_type', function($join) { $join->on('employee_type.id', '=', 'employee_vacancies.type_id'); });
        $db->leftJoin('employee_jobs', function($join) { $join->on('employee_jobs.id', '=', 'employee_vacancies.job_id'); });
        $db->leftJoin('employee_positions', function($join) { $join->on('employee_positions.id', '=', 'employee_vacancies.position_id'); });
        $db->leftJoin('employee_divisions', function($join) { $join->on('employee_divisions.id', '=', 'employee_vacancies.division_id'); });
    }

    protected function onWhere($db){
        $user_id = \Auth::User()->id;
        $isAdmin = \Auth::User()->isAdmin();
        if(!$isAdmin){
            $db->where("employee_divisions.superior_id", $user_id);
        }
    }
    
    public function Job(){
        return $this->belongsTo(Job::class, "job_id");
    }

    public function Type(){
        return $this->belongsTo(EmployeeType::class, "type_id");
    }

    public function Division(){
        return $this->belongsTo(Division::class, "division_id");
    }

    public function Position(){
        return $this->belongsTo(Position::class, "position_id");
    }   
    
    public function Acceptance() {
        return $this->hasMany(Acceptance::class);
    }

    

    /**
     * Get the value of isAcceptance
     */ 
    public function getIsAcceptance()
    {
        return $this->isAcceptance;
    }

    /**
     * Set the value of isAcceptance
     *
     * @return  self
     */ 
    public function setIsAcceptance($isAcceptance)
    {
        $this->isAcceptance = $isAcceptance;

        return $this;
    }
}