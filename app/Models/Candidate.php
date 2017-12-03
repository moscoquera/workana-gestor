<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Candidate extends Model
{


    use CrudTrait;
    protected $fillable=['name'];

}
