<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CityElection extends Model
{

    use CrudTrait;
    protected $table='city_election_candidates';
    protected $fillable=['election_candidate_id','city_id','votes'];


    protected $appends=['election_id'];

    public function city(){
        return $this->belongsTo(City::class);
    }

    public function candidature(){
        return $this->belongsTo(ElectionCandidate::class,'election_candidate_id');
    }


    public function getelectionIdAttribute(){
        return $this->candidature->election->id;
    }

}
