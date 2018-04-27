<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElectionUser extends Model
{
    use CrudTrait;
    use SoftDeletes;

    protected $fillable=['user_id','candidacy_id',
    'zoned','registered','controlled','bonuses',
    'kit','payroll','payment','number_of_payments','transport_requeriment'];

    public function candidacy(){
        return $this->belongsTo(ElectionCandidate::class);
    }

    public function user(){
        return $this->belongsTo(PublicUser::class);
    }

}
