<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Models\Employees\EmployeeAnnual;
use App\Http\Requests\DataTableRequest;
use Illuminate\Http\Request;

class EmployeeAnnualController extends ApiController{

    public function __construct() {
        parent::__construct();
        $this->model = new EmployeeAnnual;
    }

    public function dataTable(Request $request) {
        try {
            $dataTable = new DataTableRequest($request);
            $this->model->setEmployeeId($request->get("employee_id"));
            $this->model->setManagerId($request->get("manager_id"));
            $this->model->setMode($request->get("mode"));
            $data = $this->model->datatable($dataTable);
            return response()->json($data);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

}