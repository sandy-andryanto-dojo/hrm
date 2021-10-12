<?php

namespace App\Core\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\DataTableRequest;
use Prettus\Repository\Contracts\Transformable;
use Prettus\Repository\Traits\TransformableTrait;
use OwenIt\Auditing\Contracts\Auditable;
use Illuminate\Database\Eloquent\SoftDeletes;
use DB;


class MyModel extends Model implements Transformable, Auditable{

    use SoftDeletes, \OwenIt\Auditing\Auditable, TransformableTrait;

    protected $dates = ['deleted_at'];


    public function TableName() {
        return with(new static)->getTable();
    }

    public static function ToSlug($str){
        $str = strtolower(trim($str));
        $str = preg_replace('/[^a-z0-9-]/', '-', $str);
        $str = preg_replace('/-+/', "-", $str);
        return $str;
   }

    public function exportDataColumn(){
        return array();
    }

    public function datatableConfig(){
        return [
            "column"=> array(),
            "filter"=> array()
        ];
    }

    public function exportData(){
        $table = $this->TableName();
        $column = $this->exportDataColumn();
        $data = self::select($column)->where($table.".id","<>", 0);
        $this->onWhere($data);
        $this->onJoin($data);
        return $data->get()->toArray();
    }
    
    public function datatable(DataTableRequest $request){
        $config = $this->datatableConfig();
        $search = $request->getSearch();
        $sort = [$request->getSortColumnIndex(), $request->getSortDirection()];
        $limit = $request->getDisplayLength();
        $offset = $request->getDisplayStart();
        $column = $config["column"];
        $total_data = $this->datatableEloquent()->count();
        $data = $this->datatableEloquent();
        $filter = $config["filter"];
        if ($search != '') {
            $data->where(function($q) use ($search, $filter) {
                for ($i = 0; $i < count($filter); $i++) {
                    if (isset($filter[$i])) {
                        if ($i == 0) {
                            $q->Where($filter[$i], 'like', '%' . $search . '%');
                        } else {
                            $q->orWhere($filter[$i], 'like', '%' . $search . '%');
                        }
                    }
                }
            });
        }
        $data->orderBy($filter[$sort[0]], $sort[1]);
        $total_filtered = $data->count();
        $data->skip($offset)->take($limit);
        return array(
            "sEcho" => $request->getEcho(),
            "iTotalRecords" => intval($total_data),
            "iTotalDisplayRecords" => intval($total_filtered),
            "aaData" => $data->get($column),
        );
    }

    public function datatableEloquent(){
        $config = $this->datatableConfig();
        $table = $this->TableName();
        $column = $config["column"];
        $data = self::where($table.".id","<>", 0);
        $this->onWhere($data);
        $this->onJoin($data);
        return $data;
    }

    public function removed($id){
        $table = $this->TableName();
        return self::where($table.".id", $id)->delete();
    }

    public function findData($id){
        return self::findOrFail($id);
    }

    public function createCode($key){
        $table = $this->TableName();
        $data = DB::select("SELECT * FROM ".$table." ORDER BY ".$table.".id DESC LIMIT 1 ");
        if(isset($data[0])){
            $code = $data[0]->code;
            $number = substr($code,1,3);
            $val = (int)$number + 1;
            $i_number = strlen($val);
            for ($i = 3; $i > $i_number; $i--) {
                $val = "0" . $val;
            }
            return $key."".$val;
        }else{
            return $key."001";
        }
    }

    public function getByTrimValue($column, $value){
        $table = $this->TableName();
        $sql = "SELECT ".$column." from ".$table." WHERE REPLACE(LOWER(trim(".$column.")), ' ', '') = REPLACE(LOWER(trim('".$value."')), ' ', '') LIMIT 1";
        $data = DB::select($sql);
        if(isset($data[0])){
            return $data[0];
        }else{
            return null;
        }
    }

    protected function onJoin($db){}
    protected function onWhere($db){}

   

}