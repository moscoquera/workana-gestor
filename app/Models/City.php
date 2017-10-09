<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{

    use CrudTrait;
    protected $fillable=['name','department_id'];

    public function department(){
        return $this->belongsTo('App\Models\Department');
    }

}
