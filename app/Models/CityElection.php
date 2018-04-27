<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CityElection extends Model
{

    use CrudTrait;
    protected $table='city_election_candidates';
    protected $fillable=['candidacy_id','city_id','votes','inscribed','registered','effectivity'];


    public function city(){
        return $this->belongsTo(City::class);
    }

    public function candidacy(){
        return $this->belongsTo(ElectionCandidate::class);
    }


}
