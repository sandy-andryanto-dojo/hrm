<?php

namespace App\Core\Controllers;

use App\Core\Controllers\AppController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Traits\Authorizable;
use Excel;

class MyController extends AppController{

	use Authorizable;

	protected $model, $route, $codeIndex = "";
	protected $useCode = false;
	protected $exportTitle = "EXPORT";

    const SUCCESS_MESSAGE_SAVED = "Berhasil simpan data";
	const SUCCESS_MESSAGE_UPATED = "Berhasil edit data";
	const SUCCESS_MESSAGE_DELETED = "Berhasil hapus data"; 
	const FAILED_MESSAGE_SAVED = "Gagal simpan data";
	const FAILED_MESSAGE_UPATED = "Gagal edit data";
	const FAILED_MESSAGE_DELETED = "Gagal hapus data"; 

	public function index(){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
        return view('core.'.$this->route.'.index', $items);
	}
	
	public function create(){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
		$config = $this->onCreate($items);
        return view('core.'.$this->route.'.create', $items);
	}
	
	public function store(Request $request){
        $rules = $this->storeValidation();
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
			$this->beforeStore($request);
			$post = $request->all();
			if($this->useCode == true){
				$post["code"] = $this->model->createCode($this->codeIndex);
			}
            $data = $this->model->create($post);
			$id = $data->id;
			$this->afterStore($request, $data);
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_SAVED);
        }
	}
	
	public function show($id){
		if((int)$id == 0) return $this->download();
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
		$items["data"] = $this->model->findData($id);
		$items["form"] = ["method"=>"DELETE", "route"=>[$this->route.'.destroy',  $id]];
		$config = $this->onShow($items);
		return view('core.'.$this->route.'.show', $config);
	}
	
	public function edit($id){
		$items = array();
		$items["metaPermission"] = $this->metaPermission();
		$items["data"] = $this->model->findData($id);
		$config = $this->onEdit($items);
        return view('core.'.$this->route.'.edit', $config);
	}
	
	public function update(Request $request, $id){
        $rules = $this->updateValidation($id);
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        } else {
			$this->beforeUpdate($request, $id);
            $post = $request->all();
            $data = $this->model->findData($id);
            $data->fill($post);
			$data->save();
			$this->afterUpdate($request, $data);
            return redirect()->route($this->route.".show", ["id"=>$id])->with('success', self::SUCCESS_MESSAGE_UPATED);
        }
	}
	
	public function destroy($id){
		$this->beforeDestroy($id);
		$this->model->removed($id);
		$this->afterDestroy($id);
        return redirect()->route($this->route.".index")->with('success', self::SUCCESS_MESSAGE_DELETED);
	}

	public function download(){
		$data = $this->model->exportData();
		$title = $this->exportTitle;
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

	protected function storeValidation(){
		return array();
	}

	protected function updateValidation($id){
		return array();
	}

	protected function onCreate($items){ return $items; }
    protected function onEdit($items){ return $items; }
    protected function onShow($items){ return $items; }
    protected function beforeStore(Request $request){}
    protected function beforeUpdate(Request $request, $id){}
    protected function beforeDestroy($id){}
    protected function afterStore(Request $request, $data){}
    protected function afterUpdate(Request $request, $data){}
    protected function afterDestroy($id){}
	
	protected function metaPermission(){
        $result = array();
        $permission = ["view","add","edit","delete"];
        foreach($permission as $perm){
           $status = \Auth::User()->can(strtolower($perm.'_'.$this->route)) ? 1 : 0;
           $result[] = '<meta name="can_'.$perm.'" content="'.$status.'">';
        }
        return implode(null, $result);
    }
    
}