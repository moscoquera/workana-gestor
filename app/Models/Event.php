<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use CrudTrait;
    protected $fillable=[
        'name','dateandtime','address','user_id','observations','type_id','status_id','city_id'
    ];

    public function type(){
        return $this->belongsTo(EventType::class);
    }

    public function status(){
        return $this->belongsTo(EventStatus::class);
    }

    public function user(){
        return $this->belongsTo(PublicUser::class);
    }

    public function city(){
        return $this->belongsTo(City::class);
    }

}
