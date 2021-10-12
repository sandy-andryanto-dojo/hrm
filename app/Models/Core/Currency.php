<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model{

    protected $table = 'currencies';
    protected $fillable = [
        'entity',
        'name',
        'code1',
        'code2',
        'minor_unit',
        'withdraw_date',
    ];

    

}