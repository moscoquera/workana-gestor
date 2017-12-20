<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumEducation extends Model
{

    protected $table='educations';

    protected $fillable=['curriculum_id','profession_id','educational_institution_id','completion_year','type_id'];
    protected $appends=['city_name','department_name'];


    public function educational_institution(){
       return $this->belongsTo(EducationalInstitution::class);
    }

    public function getCityNameAttribute(){
        return ($this->educational_institution)?$this->educational_institution->city_name:'';
    }

    public function getDepartmentNameAttribute(){
        return ($this->educational_institution)?$this->educational_institution->department_name:'';
    }



}
