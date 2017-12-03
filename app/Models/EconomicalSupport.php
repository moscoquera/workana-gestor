<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class EconomicalSupport extends Model
{


    use CrudTrait;
    protected $fillable=['election_user_id','date','value','type'];

    public function scopeCredit($query){
        return $query->where('type',1);
    }

    public function scopeDebit($query){
        return $query->where('type',0);
    }
}
