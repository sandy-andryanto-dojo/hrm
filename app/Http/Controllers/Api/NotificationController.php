<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace App\Http\Controllers\Api;

use App\Core\Controllers\ApiController;
use App\Models\Core\Message;
use App\Http\Requests\DataTableRequest;
use Illuminate\Http\Request;

class NotificationController extends ApiController{

    public function __construct() {
        parent::__construct();
        $this->model = new Message;
    }

    public function dataTable(Request $request) {
        try {
            $dataTable = new DataTableRequest($request);
            $read = $request->get("is_read") ? $request->get("is_read") : 0;
            $this->model->setIsRead($read);
            $data = $this->model->datatable($dataTable);
            return response()->json($data);
        } catch (Exception $ex) {
            return response()->json($ex);
        }
    }

    public function getNotification(){
        $user_id = \Auth::User()->id;
        $list = Message::where("messages.to_id", $user_id)
            ->Leftjoin('users_profile', function($join) {
                $join->on('users_profile.user_id', '=', 'messages.from_id');
            })
            ->where("messages.is_read", 0)
            ->orderBy("messages.id","DESC")
            ->take(30)
            ->get();
        $response = [
            "totalRead"=>Message::where("to_id", $user_id)->where("is_read", 1)->count(),
            "totalUnRead"=>Message::where("to_id", $user_id)->where("is_read", 0)->count(),
            "list"=>$list,
        ];
        return response()->json($response);
    }

}