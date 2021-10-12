<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Models\Recruitment\Vacancy;
use App\Http\Requests\DataTableRequest;
use Illuminate\Http\Request;

class VacancyController extends ApiController{

    public function __construct() {
        parent::__construct();
        $this->model = new Vacancy;
    }

    public function dataTable(Request $request) {
        try {
            $dataTable = new DataTableRequest($request);
            $isAcceptance = $request->get("isAcceptance") ? true  : false;
            $this->model->setIsAcceptance($isAcceptance);
            $data = $this->model->datatable($dataTable);
            return response()->json($data);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

}