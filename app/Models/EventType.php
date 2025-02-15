<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class EventType extends Model
{

    use CrudTrait;
    protected $table='types';

    protected $attributes=[
        'type'=>'event',
        'order'=>0
    ];

    protected $fillable=['name','order'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope('events',function(Builder $query){
            return $query->where('type','event')->orderBy('order','asc');
        });
    }


}
