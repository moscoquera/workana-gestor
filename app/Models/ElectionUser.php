<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ElectionUser extends Model
{
    use CrudTrait;
    use SoftDeletes;

    protected $fillable=['election_id','user_id','proyected_votes','registered_votes',
    'controlled_votes','identified_votes','transport_requeriment','transport_cost','refreshments',
    'kit','payroll','payment','number_of_payments','house_support','activity_id'];

    public function election(){
        return $this->belongsTo(Election::class);
    }

    public function user(){
        return $this->belongsTo(PublicUser::class);
    }

    public function activity(){
        return $this->belongsTo(ElectionSupportType::class,'activity_id');
    }

    public function credits(){
        return $this->hasMany(EconomicalSupport::class)->credit();
    }

    public function debits(){
        return $this->hasMany(EconomicalSupport::class)->debit();
    }

    public function getTotalCreditsAttribute(){
        return $this->hasMany(EconomicalSupport::class)->credit()->sum('value');
    }

    public function getTotalDebitsAttribute(){
        return $this->hasMany(EconomicalSupport::class)->debit()->sum('value');
    }
}
