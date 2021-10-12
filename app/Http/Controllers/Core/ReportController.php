<?php

namespace App\Http\Controllers\Core;

use App\Core\Controllers\MyController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Models\Employees\Employee;
use App\Models\Employees\EmployeeReport;
use Excel;

class ReportController extends MyController{

    public function __construct(){
        $this->model = new Employee;
        $this->route = "reports";
        $this->exportTitle = "";
        $this->useCode = false;
    }

    public function index(){
        $reports = array(
           array(
               "name"=>"Absesnsi",
               "type"=>1 ,
               "route"=>null,
           ),
           array(
                "name"=>"Cuti",
                "type"=>1,
                "route"=>null,
           ),
           array(
                "name"=>"Dinas",
                "type"=>1,
                "route"=>null,
           ),
           array(
                "name"=>"Kenaikan Pangkat",
                "type"=>2,
                "route"=>null,
           ),
           array(
                "name"=>"Lembur",
                "type"=>1,
                "route"=>null,
            ),
           array(
                "name"=>"Pegawai",
                "type"=>0,
                "route"=>route('workers.show', ["id"=>0]),
            ),
            array(
                "name"=>"Pensiun",
                "type"=>2,
                "route"=>null,
            ),
            array(
                "name"=>"Penggajian",
                "type"=>1,
                "route"=>null,
            ),
            array(
                "name"=>"Mutasi",
                "type"=>2,
                "route"=>null,
            )
        );
        sort($reports);
        $items = array();
        $items["reports"] = $reports;
        $items["month"] = (int) date("m");
        $items["year"] = date("Y");
        return view('core.reports.index',  $items);
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

        $report = new EmployeeReport();
        $data = array();
        $title = "LAPORAN";
        $code = (int) $request->get("code");
        $year = (int) $request->get("year");
        $month = (int) $request->get("month");
        $monthName = \App\Helpers\AppHelper::getMonth($month);
        $periode =  strtoupper("periode_".$monthName."_".$year);

        switch($code){
            case 1: $data = $report->getAbsence($month, $year); $title = "LAPORAN_ABSENSI_PEGAWAI_".$periode;  break;
            case 2: $data = $report->getAnnual($month, $year); $title = "LAPORAN_CUTI_PEGAWAI_".$periode;  break;
            case 3: $data = $report->getTravel($month, $year); $title = "LAPORAN_DINAS_PEGAWAI_".$periode;  break;
            case 4: $data = $report->getPromotion(); $title = "LAPORAN_KENAIKAN_PANGKAT_PEGAWAI_".$periode;  break;
            case 5: $data = $report->getOverTime($month, $year); $title = "LAPORAN_LEMBUR_PEGAWAI_".$periode;  break;
            case 6: $data = $report->getMutation(); $title = "LAPORAN_MUTASI_PEGAWAI_".$periode;  break;
            case 8: $data = $report->getPayroll($month, $year); $title = "LAPORAN_PENGGAJIAN_PEGAWAI_".$periode;  break;
            case 9: $data = $report->getRetired(); $title = "LAPORAN_PENSIUN_PEGAWAI_".$periode;  break;
            default: $data = null; break;
        }

        return Excel::create($title, function($excel) use ($data) {
            $excel->sheet('Sheet1', function($sheet) use ($data){
                if(!is_null($data) && count($data) > 0){
                    $max = count($data[0]);
                    $sheet->fromArray($data);
                    $alphabet = range('A', 'Z');
                    $firstIndex = $alphabet[0]."1";
                    $lastIndex = $alphabet[$max]."1";
                    $sheet->getStyle($firstIndex.':'.$lastIndex)->applyFromArray(array(
                        'font' => array(
                            'color' => ['argb' => 'ffffff'],
                        )
                    ));
                    $sheet->cells($firstIndex.':'.$lastIndex, function ($cells) {
                        $cells->setBackground('#2196F3');
                        $cells->setAlignment('left');
                    });
                    $sheet->setFontFamily('Arial');
                }
            });
        })->download("xlsx");
    }

    public function update(Request $request, $id){
        return abort(404);  
    }

    public function destroy($id){
        return abort(404);   
    }
    
}