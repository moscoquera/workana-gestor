<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class CompanySector extends Model
{

    use CrudTrait;
    protected $table='types';

    protected $attributes=[
        'type'=>'company_sector',
        'order'=>0
    ];

    protected $fillable=['name','order'];

    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::addGlobalScope('companysectors',function(Builder $query){
            return $query->where('type','company_sector')->orderBy('order','asc');
        });
    }

}
