<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ElectionCandidate extends Model
{

    use CrudTrait;
    protected $fillable=['observation','elected','gotten_votes','proyected_votes','candidate_id','election_id'];


    public function election(){
        return $this->belongsTo(Election::class);
    }

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

}
