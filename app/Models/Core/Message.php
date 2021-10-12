<?php

namespace App\Models\Core;

use App\Core\Models\MyModel;
use App\Models\Auth\User;
use DB;

class Message extends MyModel{

    private $isRead = 0;

    protected $table = 'messages';
    protected $fillable = [
        "from_id",
        "to_id",
        "message_id",
        "subject",
        "content",
        "status_id",
        "is_read",
        "link"     
    ];

    public function Sender(){
        return $this->belongsTo(User::class, "from_id");
    }

    public function Recevier(){
        return $this->belongsTo(User::class, "to_id");
    }

    public function datatableConfig(){
        return [
            "column"=> array(
               "messages.id",
               "messages.created_at",
               "messages.subject",
               DB::raw("CONCAT(users_profile.first_name,' ',IFNULL(users_profile.last_name,'')) as sender"),
               "messages.content",
               "messages.is_read",
               "messages.created_at"
            ),
            "filter"=> array(
                "messages.id",
                "messages.created_at",
                "messages.subject",
                "users_profile.first_name",
                "messages.content",
                "messages.created_at"
            ),
        ];
    }

    public function exportDataColumn(){
        return array();
    }

    protected function onJoin($db){
        $db->Leftjoin('users', function($join) {
            $join->on('users.id', '=', 'messages.from_id');
        });
        $db->Leftjoin('users_profile', function($join) {
            $join->on('users_profile.user_id', '=', 'users.id');
        });
        $db->Leftjoin('employees', function($join) {
            $join->on('employees.user_id', '=', 'users.id');
        });
        $db->Leftjoin('employee_divisions', function($join) {
            $join->on('employee_divisions.id', '=', 'employees.division_id');
        });
        $db->Leftjoin('employee_positions', function($join) {
            $join->on('employee_positions.id', '=', 'employees.position_id');
        });
        $db->Leftjoin('employee_type', function($join) {
            $join->on('employee_type.id', '=', 'employees.type_id');
        });
        $db->Leftjoin('employee_jobs', function($join) {
            $join->on('employee_jobs.id', '=', 'employees.job_id');
        });
        $db->Leftjoin('users_marital_status', function($join) {
            $join->on('users_marital_status.id', '=', 'users_profile.status_id');
        });
        $db->Leftjoin('users_genders', function($join) {
            $join->on('users_genders.id', '=', 'users_profile.gender_id');
        });
    }
    
    public static function SendNotif($sender_id = null, $recevier_id = null, $subject = null, $message = null, $link = null){
        $sender = $sender_id ? User::findOrfail($sender_id) : null;
        $recevier = $recevier_id ? User::findOrfail($recevier_id) : null;
        $notif = self::create([
            "from_id"=>$sender_id,
            "to_id"=>$recevier_id,
            "subject"=>$subject,
            "content"=>$message,
            "is_read"=>0,
            "link"=>$link
        ]);
        return $notif;
    }

    protected function onWhere($db){
        $read = $this->getIsRead();
        $recevier_id = \Auth::User()->id;
        $db->where("messages.is_read", $read);
        $db->where("messages.to_id", $recevier_id);
    }



    /**
     * Get the value of isRead
     */ 
    public function getIsRead()
    {
        return $this->isRead;
    }

    /**
     * Set the value of isRead
     *
     * @return  self
     */ 
    public function setIsRead($isRead)
    {
        $this->isRead = $isRead;

        return $this;
    }
}