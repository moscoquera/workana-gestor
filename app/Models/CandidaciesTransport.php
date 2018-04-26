<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class CandidaciesTransport extends Model
{

	use CrudTrait;
	protected $fillable=['candidacy_id','requested','given','cost'];

	public function candidacy(){
		return $this->belongsTo(ElectionCandidate::class);
	}
}
