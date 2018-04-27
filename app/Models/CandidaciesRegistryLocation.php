<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CandidaciesRegistryLocation extends Model
{
	use CrudTrait;

	protected $fillable=['candidacy_id','poll_place','votes','inscribed','registered','effectivity'];




	public function candidacy(){
		return $this->belongsTo(ElectionCandidate::class);
	}

}
