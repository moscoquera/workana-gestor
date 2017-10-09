<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{

    use CrudTrait;
    protected $fillable=['name','nit','address','phone'];


}
