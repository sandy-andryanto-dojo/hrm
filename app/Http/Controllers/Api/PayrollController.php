<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Models\Employees\EmployeePayroll;
use App\Http\Requests\DataTableRequest;
use Illuminate\Http\Request;

class PayrollController extends ApiController{

    public function __construct() {
        parent::__construct();
        $this->model = new EmployeePayroll;
    }

    public function dataTable(Request $request) {
        try {
            $dataTable = new DataTableRequest($request);
            $this->model->setMonth($request->get("month") ? $request->get("month") : 0);
            $this->model->setYear($request->get("year") ? $request->get("year") : 0);
            $data = $this->model->datatable($dataTable);
            return response()->json($data);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

}