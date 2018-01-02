<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Level extends Model
{

    use CrudTrait;

    protected $fillable=['name','slug'];

    public function attendance(){
        return $this->morphTo(Attendance::class,'attende');
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }


}
