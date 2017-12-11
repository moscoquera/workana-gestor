<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Neighborhood extends Model
{


    use CrudTrait;

    protected $fillable=['city_id','town_id','name'];


    public function town(){
        return $this->belongsTo(Town::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }


}
