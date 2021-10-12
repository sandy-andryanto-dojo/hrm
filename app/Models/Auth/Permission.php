<?php

namespace App\Models\Auth;

class Permission extends \Spatie\Permission\Models\Permission { 

    public static function defaultPermissions(){
         $result = array();
         $actions = ["view","add","edit","delete"];
         $modules = [
           // Dashboard
           "dashboards",

           // Master Data
           "banks",
           "holidays",
           "contacts",
           "provinces",
           "regencies",
           "districts",
           "villages",
           "industries",
           "annual_types",
           "identity_types",
           "jobs",
           "specializations",
           "attachment_types",
           "allowance_types",
           "loss_types",
           "employee_types",
           "marital_status",
           
           // Kepegawaian
           "workers",
           "employee_allowances",
           "employee_cuts",
           "employee_mutations",
           "employee_promotions",
           "employee_retireds",

           // Oranisasi
           "divisions",
           "positions",

           // Permohanan
           "employee_absences",
           "employee_annuals",
           "employee_travels",
           "employee_over_times",
           "employee_loans",

           // Perekrutan
           "vacancies",
           "candidates",
           "acceptances",

           // Penggajihan
           "payrolls",

           // Laporan
           "reports",
           
           // Settings
           "accounts",
           "audits",
           "roles",
           "users",
           "notifications",
           "profiles",
           "companies"
         ];
         foreach($actions as $action){
             foreach($modules as $module){
                 $result[] = $action."_".$module;
             }
         }
         return $result;
    }

}