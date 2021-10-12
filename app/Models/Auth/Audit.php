<?php

namespace App\Models\Auth;

use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\DataTableRequest;

class Audit extends Model{

    protected $table = 'audits';
    protected $fillable = [
        'user_id',
        'event',
        'auditable_id',
        'auditable_type',
        'old_values',
        'new_values',
        'url',
        'ip_address',
        'user_agent',
        'tags'        
    ];
    
    public function datatableConfig(){
        return [
            "column"=> array(
                "audits.user_id",
                "users.username",
                "event",
                "url",
                "ip_address",
                "audits.created_at",
                "users.username",
                "users.email",
                "attachments.path"
            ),
            "filter"=> array(
                "audits.id",
                "users.username",
                "users.email",
                "event",
                "url",
                "ip_address",
                "audits.id"
            ),
        ];
    }

    public function TableName() {
        return with(new static)->getTable();
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
            "aaData" => $data->get($column)
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

    protected function onJoin($db){
        $db->join('users', function($join) {
            $join->on('users.id', '=', 'audits.user_id');
        });
        $db->join('users_profile', function($join) {
            $join->on('users_profile.user_id', '=', 'audits.user_id');
        });
        $db->leftJoin('attachments', function($join) {
            $join->on('attachments.model_id', '=', 'audits.user_id');
        });
    }

    protected function onWhere($db){}

}