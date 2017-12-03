<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Election extends Model
{

    use CrudTrait;
    protected $fillable=[
        'date','type_id','name'
    ];

    protected $casts=[
        'date'=>'date'
    ];



    public function type(){
        return $this->belongsTo(ElectionType::class);
    }

}
