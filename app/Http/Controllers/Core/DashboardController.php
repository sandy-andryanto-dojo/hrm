<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Auth\Audit;

class DashboardController extends MyController{

    public function __construct(){
        $this->model = new Audit;
        $this->route = "dashboards";
        $this->exportTitle = "";
        $this->useCode = false;
    }

    public function index(){

        $month = (int) date("m");
        $year = date("Y");
        $month_name = \App\Helpers\AppHelper::getMonth($month);

        $items  = array();
        $items["period"]  = "Periode ".$month_name." ".$year;
        $items["year"] = $year;
        $items["month"] = (int) $month;

        return view("core.dashboards.index", $items);
    }

    public function create(){
        return abort(404);    
    }

    public function show($id){
        return abort(404);   
    }

    public function edit($id){
        return abort(404);   
    }

    public function store(Request $request){
        return abort(404);  
    }

    public function update(Request $request, $id){
        return abort(404);  
    }

    public function destroy($id){
        return abort(404);   
    }
    
}