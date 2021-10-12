<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Models\Core\Currency;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class CurrencyController extends ApiController{

    public function __construct() {
        parent::__construct();
    }

    public function getCurrencies(Request $request){
        $search = $request->get("q");
        $result = Currency::select(DB::raw("
            name as id,
            name as text
        "))
        ->where(function($q) use ($search) {
            $q->where('name', 'LIKE', '%'.$search.'%');
        })->take(10)->orderBy("name","ASC")->get();
        return response()->json($result);
    }

}