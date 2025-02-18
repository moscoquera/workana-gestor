<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    use CrudTrait;

    protected $fillable=['name'];

    public function Users(){
        return $this->belongsToMany('App\Models\PublicUser');
    }

}
