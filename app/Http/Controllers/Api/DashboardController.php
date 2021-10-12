<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\AppController;
use App\Models\Employees\EmployeeDashboard;
use App\Models\Employees\Employee;
use App\Models\Organization\Division;
use App\Models\Recruitment\Vacancy;
use App\Models\Employees\EmployeeMutation;
use App\Models\Employees\EmployeePromotion;
use App\Models\Employees\EmployeeRetired;
use Illuminate\Http\Request;

class DashboardController extends AppController{

    public function getDashboard(Request $request){
        $month = $request->get("month") ? $request->get("month") : (int) date("m");
        $year = $request->get("year") ? $request->get("year") : (int) date("Y");
        $totalEmployee = Employee::count();
        $dashboard = new EmployeeDashboard();
        $items = array();
        $items["employee"] = $totalEmployee;
        $items["division"] = Division::count();
        $items["vacancy"] =  Vacancy::count();
        $items["mutation"] = EmployeeMutation::count();
        $items["promotion"] =  EmployeePromotion::count();
        $items["retired"] =  EmployeeRetired::count();
        $items["employeeChart"] = $dashboard->getEmployeeChart();
        $items["annual"] = array(
            "all"=>$dashboard->countAnnualChart($month, $year, 0, true),
            "pending"=>$dashboard->countAnnualChart($month, $year, 0),
            "approved"=>$dashboard->countAnnualChart($month, $year, 1),
            "rejected"=>$dashboard->countAnnualChart($month, $year, 2)
        );
        $items["travel"] = array(
            "all"=>$dashboard->countTravelChart($month, $year, 0, true),
            "pending"=>$dashboard->countTravelChart($month, $year, 0),
            "approved"=>$dashboard->countTravelChart($month, $year, 1),
            "rejected"=>$dashboard->countTravelChart($month, $year, 2)
        );
        $items["overtime"] = array( 
            "all"=>$dashboard->countOvertimeChart($month, $year, 0, true),
            "pending"=>$dashboard->countOvertimeChart($month, $year, 0),
            "approved"=>$dashboard->countOvertimeChart($month, $year, 1),
            "rejected"=>$dashboard->countOvertimeChart($month, $year, 2)
        );
        return response()->json($items);
    }

}