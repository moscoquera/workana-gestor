<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{

    protected $fillable=['curriculum_id','company','boss','phone','start_date','end_date','retirement','functions_in_charge'];

}
