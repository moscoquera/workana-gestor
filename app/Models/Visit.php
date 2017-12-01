<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{

    protected $fillable=['dateandtime','address','description','comments'];
    protected $casts=[
        'dateandtime'=>'datetime',
    ];

    use CrudTrait;


    public function attendance(){
        return $this->morphMany(Attendance::class,'attendable');
    }


}
