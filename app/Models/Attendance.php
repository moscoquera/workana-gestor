<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{

    use CrudTrait;
    protected $fillable=['attende_id','attende_type','attended','attendable_id','attendable_type'];

    protected $casts=[
        'attended'=>'boolean'
    ];


    public function attendable(){
        return $this->morphTo();
    }

    public function attende(){
        return $this->morphTo();
    }

    public function visit(){
        return $this->belongsTo(Visit::class,'attendable_id');
    }

    public function event(){
        return $this->belongsTo(Event::class,'attendable_id');
    }



}
