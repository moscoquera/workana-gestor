<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CandidaciesZoned extends Model
{
    use CrudTrait;
	protected $fillable=['candidacy_id','total','without_incidence','with_incidence','proyected','percentage'];


    public function candidacy(){
    	return $this->belongsTo(ElectionCandidate::class);
    }
}
