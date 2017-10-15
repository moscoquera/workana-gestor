<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reference extends Model
{
    protected $fillable=['type','curriculum_id','fullname','profession','phone'];
}
