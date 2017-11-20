<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Event;

class Level extends Model
{

    protected $fillable=['name','slug'];

    public function attendance(){
        return $this->morphTo(Attendance::class,'attende');
    }

    public function events(){
        return $this->belongsToMany(Event::class);
    }


}
