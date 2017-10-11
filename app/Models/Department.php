<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    use CrudTrait;

    protected $fillable=['name'];
}
