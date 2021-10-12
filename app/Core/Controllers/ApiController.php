<?php

namespace App\Core\Controllers;

use App\Core\Controllers\AppController;
use App\Http\Requests\DataTableRequest;
use Illuminate\Http\Request;

class ApiController extends AppController{

    protected $model;

    public function __construct(){}

    public function dataTable(Request $request) {
        try {
            $dataTable = new DataTableRequest($request);
            $data = $this->model->datatable($dataTable);
            return response()->json($data);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

    public function destroy($id){
        $response = $this->model->removed($id);
        return response()->json($response);
    }
    
}