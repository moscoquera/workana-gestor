<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CandidaciesRegistry extends Model
{
    use CrudTrait;
    protected $fillable=['candidacy_id','registered','controlled','manual','precounted','final','effectivityt','visited','trained'];

    public function candidacy(){
    	return $this->belongsTo(ElectionCandidate::class);
    }
}
