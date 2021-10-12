<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Models\Core\Regency;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegencyController extends ApiController{

    public function __construct() {
        parent::__construct();
        $this->model = new Regency;
    }

    public function getByProvinceId(Request $request, $id){
        $search = $request->get("q");
        $result = Regency::select(DB::raw("
            id as id,
            name as text
        "))
        ->where("province_id", $id)
        ->where(function($q) use ($search) {
            $q->where('name', 'LIKE', '%'.$search.'%');
        })->take(10)->orderBy("name","ASC")->get();
        return response()->json($result);
    }

}