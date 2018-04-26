<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class SupportHouse extends Model
{

	use CrudTrait;
    protected $fillable=['city_id','poll_place','address','phone','contact','enter_date'];



    public function city(){
    	return $this->belongsTo(City::class);
    }
}
