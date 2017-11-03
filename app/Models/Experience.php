<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{

    protected $fillable=['curriculum_id','currently','company','boss','phone','start_date','end_date','retirement','functions_in_charge','company_id','sector_id'];

    protected $casts=[
        'currently'=>'boolean',
        'company_id'=>'integer'
    ];

}
