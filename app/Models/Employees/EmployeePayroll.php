<?php

namespace App\Models\Employees;

use App\Core\Models\MyModel;
use App\Http\Requests\DataTableRequest;
use App\Models\Employees\Employee;
use DB;

class EmployeePayroll extends MyModel{

    private $month, $year;

    protected $table = 'employee_payroll';
    protected $fillable = [
        "employee_id",
        "payment_number",
        "payment_date",
        "total_absence",
        "basic_pay",
        "total_allowance",
        "total_bonus",
        "gross_salary",
        "total_loss",
        "total_loan",
        "take_home_salary",
        "month",
        "year"
    ];

    public function datatable(DataTableRequest $request){
        $config = $this->datatableConfig();
        $search = $request->getSearch();
        $sort = [$request->getSortColumnIndex(), $request->getSortDirection()];
        $limit = $request->getDisplayLength();
        $offset = $request->getDisplayStart();

        $_month = $this->getMonth();
        $_year = $this->getYear();

        $column = array(
            "employees.id",
            "employees.employee_number",
            DB::raw("CONCAT(users_profile.first_name,' ',IFNULL(users_profile.last_name,'')) as employee_name"),
            "employee_divisions.name as division_name",
            "employee_positions.name as position_name",
            "employee_type.name as type_name",
            "employee_positions.month_salary",
            DB::raw("(".$this->getAllowances($_month, $_year).") as total_allowances"),
            DB::raw("(".$this->getCuts($_month, $_year).") as total_cuts"),
            DB::raw($this->getTakeHome($_month, $_year)),
            DB::raw("(SELECT COUNT(*) FROM employee_payroll WHERE employee_payroll.month = ".$_month." AND employee_payroll.year = ".$_year." AND employee_payroll.employee_id = employees.id) as status"),
            "employees.created_at"
        );

        $total_data = Employee::count();
        $data = Employee::where("employees.id","<>", 0);
        $data->Leftjoin('users_profile', function($join) {
            $join->on('users_profile.user_id', '=', 'employees.user_id');
        });
        $data->Leftjoin('employee_divisions', function($join) {
            $join->on('employee_divisions.id', '=', 'employees.division_id');
        });
        $data->Leftjoin('employee_positions', function($join) {
            $join->on('employee_positions.id', '=', 'employees.position_id');
        });
        $data->Leftjoin('employee_type', function($join) {
            $join->on('employee_type.id', '=', 'employees.type_id');
        });
        
        $filter = array(
            "employees.id",
            "employees.employee_number",
            "users_profile.first_name",
            "users_profile.last_name",
            "employee_divisions.name",
            "employee_positions.name",
            "employee_type.name",
            "employee_positions.month_salary",
            "employees.id",
            "employees.id",
            "employees.id",
            "employees.id",
            "employees.created_at"
        );

        if ($search != '') {
            $data->where(function($q) use ($search, $filter) {
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
        $data->orderBy($filter[$sort[0]], $sort[1]);
        $total_filtered = $data->count();
        $data->skip($offset)->take($limit);
        return array(
            "sEcho" => $request->getEcho(),
            "iTotalRecords" => intval($total_data),
            "iTotalDisplayRecords" => intval($total_filtered),
            "aaData" => $data->get($column),
        );
    }

    public function getTakeHome($month, $year){
       $sql = "(employee_positions.month_salary + (".$this->getAllowances($month, $year).") - (".$this->getCuts($month, $year).")) as take_home";
       return trim(preg_replace('/\s+/', ' ', $sql));  
    }

    public function getCuts($month, $year){
        $sql = "
            (
                SELECT IFNULL(SUM(cost), 0) FROM employee_cuts
                INNER JOIN employee_loss_type ON employee_cuts.type_id = employee_loss_type.id
                WHERE employee_loss_type.name NOT IN ('Potongan Kehadiran') AND employee_id = employees.id
            )
            +
            (
                (
                    SELECT IFNULL(SUM(cost), 0) FROM employee_cuts
                    INNER JOIN employee_loss_type ON employee_cuts.type_id = employee_loss_type.id
                    WHERE employee_loss_type.name = 'Potongan Kehadiran' AND employee_id = employees.id
                )
                *
                (
                    (
                        SELECT IFNULL(SUM(DAY(end_date)) - SUM(DAY(start_date)), 0) as total_days
                        FROM employee_annual
                        WHERE employee_id = employees.id
                        AND is_approved = 1
                        AND MONTH(request_date) = ".$month."
                        AND YEAR(request_date) = ".$year."
                    )
                    +
                    (
                        SELECT COUNT(*) as total_days
                        FROM employee_absence
                        WHERE employee_id = employees.id
                        AND is_aprroved = 1
                        AND total = 0
                        AND is_holiday = 0
                        AND MONTH(absence_date) = ".$month."
                        AND YEAR(absence_date) = ".$year."
                    )
                )
            ) 
        ";
        return trim(preg_replace('/\s+/', ' ', $sql)); 
    }

    public function getAllowances($month, $year){
        $sql = "
            (
                SELECT IFNULL(SUM(cost), 0) FROM employee_allowances
                INNER JOIN employee_allowance_type ON employee_allowances.type_id = employee_allowance_type.id
                WHERE employee_allowance_type.name NOT IN ('Transportasi','Lembur','Uang Makan') AND employee_id = employees.id
            )
            +
            (
                (
                    SELECT IFNULL(SUM(cost), 0) FROM employee_allowances
                    INNER JOIN employee_allowance_type ON employee_allowances.type_id = employee_allowance_type.id
                    WHERE employee_allowance_type.name = 'Lembur' AND employee_id = employees.id
                ) 
                *
                (
                    SELECT IFNULL((SUM(HOUR(end_hour)) - SUM(HOUR(start_hour))), 0) as total_hours
                    FROM employee_over_time 
                    WHERE employee_id = employees.id
                    AND is_approved = 1
                    AND MONTH(request_date) = ".$month."
                    AND YEAR(request_date) = ".$year."
                )
            )
            +
            (
                SELECT IFNULL(SUM(cost),0) as total_reimburse
                FROM employee_travel 
                WHERE employee_id = employees.id
                AND is_approved = 1
                AND MONTH(request_date) = ".$month."
                AND YEAR(request_date) = ".$year."
            )
            +
            (
                (
                    SELECT IFNULL(SUM(cost), 0) FROM employee_allowances
                    INNER JOIN employee_allowance_type ON employee_allowances.type_id = employee_allowance_type.id
                    WHERE employee_allowance_type.name = 'Uang Makan' AND employee_id = employees.id
                ) 
                *
                (
                    SELECT IFNULL(SUM(DAY(end_date)) - SUM(DAY(start_date)), 0) as total_days
                    FROM employee_travel
                    WHERE employee_id = employees.id
                    AND is_approved = 1
                    AND MONTH(request_date) = ".$month."
                    AND YEAR(request_date) = ".$year."
                )
            )
        ";
        return trim(preg_replace('/\s+/', ' ', $sql));                
    }


    public function Employee() {
        return $this->belongsTo(Employee::class, "employee_id");
    }

    public static function createInvoiceNumber($month, $year){
        $data = DB::select("SELECT MAX(payment_number) as invoice_number FROM employee_payroll WHERE MONTH(created_at) = ".$month." AND YEAR(created_at) = ".$year);
        if(isset($data[0]->invoice_number) && !is_null($data[0]->invoice_number)){
            $code = $data[0]->invoice_number;
            $array = explode("/",$code);
            $number = end($array);
            $val = (int)$number + 1;
            $i_number = strlen($val);
            for ($i = 5; $i > $i_number; $i--) {
                $val = "0" . $val;
            }
            return "PRL/".date("Ymd")."/".$val;
        }else{
            return "PRL/".date("Ymd")."/00001";
        }
    }


    /**
     * Get the value of month
     */ 
    public function getMonth()
    {
        return $this->month;
    }

    /**
     * Set the value of month
     *
     * @return  self
     */ 
    public function setMonth($month)
    {
        $this->month = $month;

        return $this;
    }

    /**
     * Get the value of year
     */ 
    public function getYear()
    {
        return $this->year;
    }

    /**
     * Set the value of year
     *
     * @return  self
     */ 
    public function setYear($year)
    {
        $this->year = $year;

        return $this;
    }
}