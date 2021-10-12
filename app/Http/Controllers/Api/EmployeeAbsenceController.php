<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Http\Requests\DataTableRequest;
use Illuminate\Http\Request;
use App\Models\Employees\EmployeeAbsence;

class EmployeeAbsenceController extends ApiController{

    public function __construct() {
        parent::__construct();
        $this->model = new EmployeeAbsence;
    }

    public function dataTableByMonthYear(Request $request, $month, $year) {
        try {
            $dataTable = new DataTableRequest($request);
            $data = $this->model->datatableByMonthYear($dataTable, $month, $year);
            return response()->json($data);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

}