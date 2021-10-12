<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Models\Recruitment\Candidate;
use App\Models\Recruitment\Acceptance;

class CandidateController extends ApiController{

    public function __construct() {
        parent::__construct();
        $this->model = new Candidate;
    }

    public function destroy($id){
        $response = $this->model->removed($id);
        Acceptance::where("candidate_id", $id)->delete();
        return response()->json($response);
    }

}