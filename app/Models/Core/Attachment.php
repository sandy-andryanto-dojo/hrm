<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;
use App\Models\Master\AttachmentType;

class Attachment extends Model{

    protected $table = 'attachments';
    protected $fillable = [
        'is_folder',
        'name',
        'path',
        'type',
        'size',
        'parent_id',
        'group_id',
        'model_id',
        'model_name'
    ];

    public static function getByModel($model, $id){
        $attacment_id = is_array($id) ? $id : array($id);
        $data = self::distinct()->where("model_name", $model)->whereIn("model_id", $attacment_id)->count();
        if((int) $data == 0){
            return null;
        }else{
            if((int) $data == 1){
                return self::distinct()->where("model_name", $model)->whereIn("model_id", $attacment_id)->first();
            }else{
                return self::distinct()->where("model_name", $model)->whereIn("model_id", $attacment_id)->get();
            }
        }
    }

    public static function getByGroup($model, $id, $group_id){
        $attacment_id = is_array($id) ? $id : array($id);
        $data = self::distinct()->where("model_name", $model)->where("group_id", $group_id)->whereIn("model_id", $attacment_id)->count();
        if((int) $data == 0){
            return null;
        }else{
            if((int) $data == 1){
                return self::distinct()->where("model_name", $model)->where("group_id", $group_id)->whereIn("model_id", $attacment_id)->first();
            }else{
                return self::distinct()->where("model_name", $model)->where("group_id", $group_id)->whereIn("model_id", $attacment_id)->get();
            }
        }
    }

    public static function TableName() {
        return with(new static)->getTable();
    }

    public function Group() {
        return $this->belongsTo(AttachmentType::class, "group_id");
    }

}