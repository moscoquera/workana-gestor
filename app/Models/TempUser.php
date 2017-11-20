<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class TempUser extends Model
{

    protected $fillable=['document','first_name','last_name','address','email','phone'];

    use CrudTrait;

    public function attendance(){
        return $this->morphTo(Attendance::class,'attende');
    }



    public function getFullNameAttribute(){
        return $this->first_name.' '.$this->last_name;
    }

    public function getLevelAttribute(){
        return New Level([
            'name'=>'Externo'
        ]);
    }
}
