<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CandidaciesHouses extends Model
{
    use CrudTrait;

    protected $fillable=['candidacy_id','support_house_id','registered','controlled','manual'];

    public function candidacy(){
    	return $this->belongsTo(ElectionCandidate::class);
    }

    public function support_house(){
    	return $this->belongsTo(SupportHouse::class);
    }
}
