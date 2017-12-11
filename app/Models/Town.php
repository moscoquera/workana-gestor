<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Town extends Model
{

    use CrudTrait;

    protected $fillable=['name','city_id'];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function neighborhoods(){
        return $this->hasMany(Neighborhood::class);
    }

}
