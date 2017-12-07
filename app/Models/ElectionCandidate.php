<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ElectionCandidate extends Model
{

    use CrudTrait;
    protected $fillable=['observation','elected','gotten_votes','proyected_votes','candidate_id','election_id'];
    protected $appends=['name'];

    public function election(){
        return $this->belongsTo(Election::class);
    }

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    public function getNameAttribute(){
        if (isset($this->attributes['name'])){
            return $this->attributes['name'];
        }
        return $this->candidate->name;
    }


}
