<?php

namespace App\Helpers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

class MenuHelper {

    public static function checkRoutePermissions(array $routes){
        $hidden = "hidden";
        $routeCollection = Route::getRoutes();
        foreach ($routeCollection as $value) {
            $method = $value->methods()[0];
            $url = $value->uri();
            $name = $value->getName();
            $classAction = $value->getActionName();
            if(!is_null($name)){
                $actions = explode(".", $name);
                if(count($actions) > 1){
                    $module = $actions[0];
                    if(in_array($module, $routes) && \Auth::User()->can("view_".$module)){
                        $hidden = ""; 
                        break;
                    }
                }
            }
        }
        return $hidden;
    }

}