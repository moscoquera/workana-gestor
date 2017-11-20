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


}
