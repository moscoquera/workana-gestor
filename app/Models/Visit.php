<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{

    protected $fillable=['dateandtime','address','description','comments','result_id','next_visit','subject_id','attachments'];
    protected $casts=[
        'dateandtime'=>'datetime',
        'attachments'=>'array',
    ];

    use CrudTrait;


    public function attendance(){
        return $this->morphMany(Attendance::class,'attendable');
    }

    public function result(){
        return $this->belongsTo(VisitStatus::class,'result_id');
    }

    public function subject(){
        return $this->belongsTo(VisitSubject::class,'subject_id');
    }
}
