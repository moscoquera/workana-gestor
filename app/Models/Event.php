<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use CrudTrait;
    use SoftDeletes;

    protected $fillable=[
        'name','dateandtime','address','user_id',
        'observations','type_id','status_id','city_id','controlled','place_name',
        'attendes'
    ];

    protected $casts=[
        'dateandtime'=>'datetime'
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

    public function attendance(){
        return $this->morphMany(Attendance::class,'attendable');
    }

    public function levels(){
        return $this->belongsToMany(Level::class);
    }

    public function delete()
    {
        $res= parent::delete();
        if($res==true){
            $this->attendance()->delete();
        }

        return $res;

    }

}
