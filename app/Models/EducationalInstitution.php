<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class EducationalInstitution extends Model
{


    use CrudTrait;

    protected $fillable=['name','city_id','department_id'];
    protected $appends=['city_name','department_name'];


    public function city(){
        return $this->belongsTo(City::class);
    }

    public function department(){
        return $this->belongsTo(Department::class);
    }

    public function getCityNameAttribute(){
        return $this->city->name;
    }

    public function getDepartmentNameAttribute(){
        return $this->department->name;
    }

}
