<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class ElectionCandidate extends Model
{

    use CrudTrait;
    protected $table='candidacies';
    protected $fillable=['observation','gotten_votes','proyected_votes','candidate_id','election_date','party_votes','party_number'];
    protected $appends=['name'];

    protected $dates=['election_date'];

    public function candidate(){
        return $this->belongsTo(Candidate::class);
    }

    public function getNameAttribute(){
        return $this->candidate->first_name.' '.$this->candidate->last_name;
    }

	public function getFullNameAttribute(){
		return ($this->election_date?$this->election_date->format('Y-m-d'):'').' - '.$this->getNameAttribute();
	}

}
