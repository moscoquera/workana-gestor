<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use CrudTrait;
    protected $fillable=['name','nit','address','phone','city_id','department_id'];


    public function city(){
        return $this->belongsTo(City::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

}
