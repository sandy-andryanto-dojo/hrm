<?php

namespace App\Models\Master;

use App\Core\Models\MyModel;
use App\Models\Core\Attachment;

class AttachmentType extends MyModel{

    protected $table = 'employee_attachemt_type';
    protected $fillable = [
        'name',
        'description',
        'is_required'
    ];

    public function datatableConfig(){
        return [
            "column"=> array("id","name","description","is_required","created_at"),
            "filter"=> array("id","name","description","is_required","created_at"),
        ];
    }

    public function exportDataColumn(){
        return [
            "employee_attachemt_type.name AS NAMA",
            "employee_attachemt_type.description AS DESKRIPSI"
        ];
    }

    public static function defaultValues(){
        $data = [
            "Curriculum Vitae /  Resume",
            "Foto Copy KTP",
            "Foto Copy Ijazah",
            "Transkip Nilai",
            "Sertifikat Keahlian",
            "Sertifikat Seminar",
            "Pas Foto 4×6 atau 3×4"
        ];
        sort($data);
        return $data;
    }

    public function Attachment() {
        return $this->hasMany(Attachment::class);
    }

}