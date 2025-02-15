<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Builder;

class ElectionType extends Model
{

    use CrudTrait;
    protected $table='types';

    protected $attributes=[
        'type'=>'election',
        'order'=>0
    ];

    protected $fillable=['name','order'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope('elections',function(Builder $query){
            return $query->where('type','election')->orderBy('order','asc');
        });
    }


}
