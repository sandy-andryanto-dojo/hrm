<?php

namespace App\Models\Employees;

use Illuminate\Database\Eloquent\Model;
use App\Models\Employees\EmployeePayroll;
use DB;

class EmployeeReport extends Model{

    public function getRetired(){
        $sql = "
            SELECT 
                employees.employee_number AS NO_PEGAWAI,
                CONCAT(users_profile.first_name,' ',users_profile.last_name) as NAMA_PEGAWAI,
                employee_divisions.name as DIVISI,
                employee_positions.name as POSISI,
                employee_type.name as TIPE_PEGAWAI,
                CONCAT(FLOOR(DATEDIFF(now(), employees.join_date)/365),' ','Tahun') as MASA_KERJA
            FROM employees
            INNER JOIN users_profile ON users_profile.user_id = employees.user_id
            INNER JOIN employee_divisions ON employee_divisions.id = employees.division_id
            INNER JOIN employee_positions ON employee_positions.id = employees.position_id
            INNER JOIN employee_type ON employee_type.id = employees.type_id
            INNER JOIN employee_retired ON employee_retired.employee_id = employees.id
            WHERE employees.deleted_at IS NULL
            ORDER BY employee_divisions.name, employee_positions.name, employee_type.name, users_profile.first_name
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return json_decode(json_encode($data), true);
    }

    public function getMutation(){
        $sql = "
            SELECT 
                employees.employee_number AS NO_PEGAWAI,
                CONCAT(users_profile.first_name,' ',users_profile.last_name) as NAMA_PEGAWAI,
                eform.name as DIVISI_AWAL,
                target.name as DIVISI_AKHIR,
                employee_positions.name as POSISI,
                employee_type.name as TIPE_PEGAWAI,
                CONCAT(FLOOR(DATEDIFF(now(), employees.join_date)/365),' ','Tahun') as MASA_KERJA
            FROM employees
            INNER JOIN users_profile ON users_profile.user_id = employees.user_id
            INNER JOIN employee_type ON employee_type.id = employees.type_id
            INNER JOIN employee_positions ON employee_positions.id = employees.position_id
            INNER JOIN employee_mutations ON employee_mutations.employee_id = employees.id
            INNER JOIN employee_divisions AS eform ON eform.id = employee_mutations.division_from_id
            INNER JOIN employee_divisions AS target ON target.id = employee_mutations.division_target_id
            WHERE employees.deleted_at IS NULL
            ORDER BY employee_positions.name, employee_type.name, users_profile.first_name
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return json_decode(json_encode($data), true);
    }

    public function getPromotion(){
        $sql = "
            SELECT 
                employees.employee_number AS NO_PEGAWAI,
                CONCAT(users_profile.first_name,' ',users_profile.last_name) as NAMA_PEGAWAI,
                employee_divisions.name as DIVISI,
                eform.name as POSISI_AWAL,
                target.name as POSISI_AKHIR,
                employee_type.name as TIPE_PEGAWAI,
                CONCAT(FLOOR(DATEDIFF(now(), employees.join_date)/365),' ','Tahun') as MASA_KERJA
            FROM employees
            INNER JOIN users_profile ON users_profile.user_id = employees.user_id
            INNER JOIN employee_divisions ON employee_divisions.id = employees.division_id
            INNER JOIN employee_type ON employee_type.id = employees.type_id
            INNER JOIN employee_promotions ON employee_promotions.employee_id = employees.id
            INNER JOIN employee_positions AS eform ON eform.id = employee_promotions.position_from_id
            INNER JOIN employee_positions AS target ON target.id = employee_promotions.position_target_id
            WHERE employees.deleted_at IS NULL
            ORDER BY employee_divisions.name, employee_type.name, users_profile.first_name
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return json_decode(json_encode($data), true);
    }

    public function getPayroll($month, $year){
        $payroll = new EmployeePayroll();
        $sql = "
            SELECT 
                employees.employee_number AS NO_PEGAWAI,
                CONCAT(users_profile.first_name,' ',users_profile.last_name) as NAMA_PEGAWAI,
                employee_divisions.name as DIVISI,
                employee_positions.name as POSISI,
                employee_type.name as TIPE_PEGAWAI,
                CONCAT(FLOOR(DATEDIFF(now(), employees.join_date)/365),' ','Tahun') as MASA_KERJA,
                FORMAT(employee_positions.month_salary, 2) AS GAJI_POKOK,
                FORMAT((".$payroll->getAllowances($month, $year)."), 2) AS TUNJANGAN,
                FORMAT((".$payroll->getCuts($month, $year).") , 2) AS POTONGAN,
                FORMAT((employee_positions.month_salary + (".$payroll->getAllowances($month, $year).") - (".$payroll->getCuts($month, $year).")), 2) as GAJI_BERSIH
            FROM employees
            INNER JOIN users_profile ON users_profile.user_id = employees.user_id
            INNER JOIN employee_divisions ON employee_divisions.id = employees.division_id
            INNER JOIN employee_positions ON employee_positions.id = employees.position_id
            INNER JOIN employee_type ON employee_type.id = employees.type_id
            WHERE employees.deleted_at IS NULL
            ORDER BY employee_divisions.name, employee_positions.name, employee_type.name, users_profile.first_name
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return json_decode(json_encode($data), true);
    }


    public function getOverTime($month, $year){
        $sql = "
            SELECT 
                employees.employee_number AS NO_PEGAWAI,
                CONCAT(users_profile.first_name,' ',users_profile.last_name) as NAMA_PEGAWAI,
                employee_divisions.name as DIVISI,
                employee_positions.name as POSISI,
                employee_type.name as TIPE_PEGAWAI,
                CONCAT(FLOOR(DATEDIFF(now(), employees.join_date)/365),' ','Tahun') as MASA_KERJA,
                (
                    SELECT CONCAT(IFNULL((SUM(HOUR(end_hour)) - SUM(HOUR(start_hour))), 0), ' ', 'Jam')
                    FROM employee_over_time 
                    WHERE employee_id = employees.id
                    AND is_approved = 1
                    AND MONTH(request_date) = ".$month."
                    AND YEAR(request_date) = ".$year."
                ) AS TOTAL_JAM_KERJA
            FROM employees
            INNER JOIN users_profile ON users_profile.user_id = employees.user_id
            INNER JOIN employee_divisions ON employee_divisions.id = employees.division_id
            INNER JOIN employee_positions ON employee_positions.id = employees.position_id
            INNER JOIN employee_type ON employee_type.id = employees.type_id
            WHERE employees.deleted_at IS NULL
            ORDER BY employee_divisions.name, employee_positions.name, employee_type.name, users_profile.first_name
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return json_decode(json_encode($data), true);
    }

    public function getAbsence($month, $year){
        $sql = "
            SELECT 
                employees.employee_number AS NO_PEGAWAI,
                CONCAT(users_profile.first_name,' ',users_profile.last_name) as NAMA_PEGAWAI,
                employee_divisions.name as DIVISI,
                employee_positions.name as POSISI,
                employee_type.name as TIPE_PEGAWAI,
                CONCAT(FLOOR(DATEDIFF(now(), employees.join_date)/365),' ','Tahun') as MASA_KERJA,
                (
                    SELECT CONCAT(IFNULL(SUM(total),0), ' ', 'Jam')
                    FROM employee_absence 
                    WHERE employee_id = employees.id
                    AND is_aprroved = 1
                    AND is_holiday = 0
                    AND MONTH(absence_date) = ".$month."
                    AND YEAR(absence_date) = ".$year."
                ) AS TOTAL_JAM_KERJA,
                (
                    SELECT CONCAT(COUNT(*), ' ','Hari')
                    FROM employee_absence
                    WHERE employee_id = employees.id
                    AND is_aprroved = 1
                    AND total > 0
                    AND is_holiday = 0
                    AND MONTH(absence_date) = ".$month."
                    AND YEAR(absence_date) = ".$year."
                ) AS TOTAL_KEHADIRAN
            FROM employees
            INNER JOIN users_profile ON users_profile.user_id = employees.user_id
            INNER JOIN employee_divisions ON employee_divisions.id = employees.division_id
            INNER JOIN employee_positions ON employee_positions.id = employees.position_id
            INNER JOIN employee_type ON employee_type.id = employees.type_id
            WHERE employees.deleted_at IS NULL
            ORDER BY employee_divisions.name, employee_positions.name, employee_type.name, users_profile.first_name
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return json_decode(json_encode($data), true);
    }

  
    public function getAnnual($month, $year){
        $sql = "
            SELECT 
                employees.employee_number AS NO_PEGAWAI,
                CONCAT(users_profile.first_name,' ',users_profile.last_name) as NAMA_PEGAWAI,
                employee_divisions.name as DIVISI,
                employee_positions.name as POSISI,
                employee_type.name as TIPE_PEGAWAI,
                CONCAT(FLOOR(DATEDIFF(now(), employees.join_date)/365),' ','Tahun') as MASA_KERJA,
                (
                    SELECT CONCAT(IFNULL(SUM(DATEDIFF(employee_annual.end_date,employee_annual.start_date)), 0), ' ', 'Hari') FROM employee_annual
                    WHERE employee_annual.employee_id = employees.id AND MONTH(employee_annual.start_date) = ".$month." AND YEAR(employee_annual.start_date) = ".$year." 
                    AND employee_annual.is_approved = 1 AND employee_annual.deleted_at IS NULL
                ) AS TOTAL_CUTI
            FROM employees
            INNER JOIN users_profile ON users_profile.user_id = employees.user_id
            INNER JOIN employee_divisions ON employee_divisions.id = employees.division_id
            INNER JOIN employee_positions ON employee_positions.id = employees.position_id
            INNER JOIN employee_type ON employee_type.id = employees.type_id
            WHERE employees.deleted_at IS NULL
            ORDER BY employee_divisions.name, employee_positions.name, employee_type.name, users_profile.first_name
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return json_decode(json_encode($data), true);
    }

    public function getTravel($month, $year){
        $sql = "
            SELECT 
                employees.employee_number AS NO_PEGAWAI,
                CONCAT(users_profile.first_name,' ',users_profile.last_name) as NAMA_PEGAWAI,
                employee_divisions.name as DIVISI,
                employee_positions.name as POSISI,
                employee_type.name as TIPE_PEGAWAI,
                CONCAT(FLOOR(DATEDIFF(now(), employees.join_date)/365),' ','Tahun') as MASA_KERJA,
                (
                    SELECT CONCAT(IFNULL(SUM(DATEDIFF(employee_travel.end_date,employee_travel.start_date)), 0), ' ', 'Hari') FROM employee_travel
                    WHERE employee_travel.employee_id = employees.id AND MONTH(employee_travel.start_date) = ".$month." AND YEAR(employee_travel.start_date) = ".$year." 
                    AND employee_travel.is_approved = 1 AND employee_travel.deleted_at IS NULL
                ) AS TOTAL_PERJALANAN_DINAS
            FROM employees
            INNER JOIN users_profile ON users_profile.user_id = employees.user_id
            INNER JOIN employee_divisions ON employee_divisions.id = employees.division_id
            INNER JOIN employee_positions ON employee_positions.id = employees.position_id
            INNER JOIN employee_type ON employee_type.id = employees.type_id
            WHERE employees.deleted_at IS NULL
            ORDER BY employee_divisions.name, employee_positions.name, employee_type.name, users_profile.first_name
        ";
        $query = trim(preg_replace('/\s+/', ' ', $sql));  
        $data =  DB::select($query);
        return json_decode(json_encode($data), true);
    }


}