<?php

namespace App\Models\Recruitment;

use App\Core\Models\MyModel;
use Illuminate\Support\Facades\DB;
// Relations
use App\Models\Auth\UserBloodType;
use App\Models\Auth\UserGender;
use App\Models\Auth\UserMaritalStatus;
use App\Models\Auth\UserIdentityType;
use App\Models\Core\Country;
use App\Models\Recruitment\Acceptance;

class Candidate extends MyModel{

    protected $table = 'employee_candidates';
    protected $fillable = [
        "first_name",
        "last_name",
        "email",
        "phone",
        "identity_number",
        "birth_date",
        "birth_place",
        "country_id",
        "gender_id",
        "status_id",
        "blood_id",
        "identity_id",
        "postal_code",
        "address"
    ];

    public function datatableConfig(){
        return [
            "column"=> array(
                "employee_candidates.id",
                DB::raw("CONCAT(employee_candidates.first_name,' ',IFNULL(employee_candidates.last_name,'')) as candidate_name"),
                "employee_candidates.first_name",
                "employee_candidates.last_name",
                "employee_candidates.email",
                "employee_candidates.phone",
                "employee_candidates.identity_number",
                "employee_candidates.birth_date",
                "employee_candidates.birth_place",
                "employee_candidates.country_id",
                "employee_candidates.gender_id",
                "employee_candidates.status_id",
                "employee_candidates.blood_id",
                "employee_candidates.identity_id",
                "employee_candidates.postal_code",
                "employee_candidates.address",
                DB::raw("CEIL((DATEDIFF(now(),employee_candidates.birth_date)/365))  as umur"),
                // Relation
                "users_marital_status.name as status_name",
                "users_genders.name as gender_name",
                "users_identity_types.name as identity_name",
                "users_blood_types.name as blood_name",
                "countries.name as country_name"
            ),
            "filter"=> array(
                'employee_candidates.id',
                "employee_candidates.identity_id",
                "employee_candidates.identity_number",
                'employee_candidates.first_name',
                'users_genders.name',
                'employee_candidates.email',
                'employee_candidates.phone',
                'countries.name',
                'employee_candidates.birth_date',
                'employee_candidates.created_at'
            ),
        ];
    }

    public function exportDataColumn(){
        return [
            DB::raw("CONCAT(employee_candidates.first_name,' ',IFNULL(employee_candidates.last_name,'')) as NAMA_KANDIDAT"),
            "employee_candidates.email AS EMAIL",
            "employee_candidates.phone AS NOMOR_TELEPON",
            "employee_candidates.identity_number AS NO_IDENTITAS",
            "users_identity_types.name AS JENIS_IDENTITAS",
            "employee_candidates.birth_date AS TANGGAL_LAHIR",
            "employee_candidates.birth_place AS TEMPAT_LAHIR",
            "countries.name AS KEWARGANEGARAAN",
            "users_genders.name AS JENIS_KELAMIN",
            "users_marital_status.name AS STATUS_NIKAH",
            "users_blood_types.name AS GOLONGAN_DARAH",
            "employee_candidates.postal_code AS KODE_POS",
            "employee_candidates.address AS ALAMAT_LENGKAP"
        ];
    }

    public function Blood() {
        return $this->belongsTo(UserBloodType::class, 'blood_id');
    }

    public function Gender() {
        return $this->belongsTo(UserGender::class, 'gender_id');
    }

    public function Status() {
        return $this->belongsTo(UserMaritalStatus::class, 'status_id');
    }

    public function Country() {
        return $this->belongsTo(Country::class, 'country_id');
    }

    public function Identity() {
        return $this->belongsTo(UserIdentityType::class, 'identity_id');
    }

    protected function onJoin($db){
        $db->Leftjoin('users_marital_status', function($join) {
            $join->on('users_marital_status.id', '=', 'employee_candidates.status_id');
        });
        $db->Leftjoin('users_genders', function($join) {
            $join->on('users_genders.id', '=', 'employee_candidates.gender_id');
        });
        $db->Leftjoin('users_identity_types', function($join) {
            $join->on('users_identity_types.id', '=', 'employee_candidates.identity_id');
        });
        $db->Leftjoin('users_blood_types', function($join) {
            $join->on('users_blood_types.id', '=', 'employee_candidates.blood_id');
        });
        $db->Leftjoin('countries', function($join) {
            $join->on('countries.id', '=', 'employee_candidates.country_id');
        });
    }

    public function Acceptance() {
        return $this->hasMany(Acceptance::class);
    }

}