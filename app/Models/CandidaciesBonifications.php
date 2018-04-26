<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CandidaciesBonifications extends Model
{
    use CrudTrait;
    protected $fillable=['candidacy_id','bonuses','bonified','rosted','workers'];

    public function candidacy(){
    	return $this->belongsTo(ElectionCandidate::class);
    }

}
