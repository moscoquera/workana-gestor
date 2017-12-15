<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurriculumEducation extends Model
{

    protected $table='educations';

    protected $fillable=['curriculum_id','course_name','educational_institution_id','completion_year','type_id'];

}
