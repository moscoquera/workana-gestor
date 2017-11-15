<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contract extends Model
{
    use CrudTrait;
    use SoftDeletes;

    protected $casts=[
        'start_date'=>'date',
        'end_date'=>'date',
    ];

    protected $fillable=[
        'user_id','type_id','start_date','end_date','description'
    ];

    public function type(){
        return $this->belongsTo('\App\Models\ContractType');
    }

    public function user(){
        return $this->belongsTo('\App\Models\PublicUser');
    }

    public function scopeActive($query){
        return $query->whereRaw('start_date <= CURDATE()')->whereRaw('end_date >= CURDATE()');
    }

    public function scopeEnded($query){
        return $query->whereRaw('end_date <CURDATE()');
    }

    public function scopeNoStarted($query){
        return $query->whereRaw('start_date > CURDATE()');
    }



}
