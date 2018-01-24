<?php

namespace App\Models;

use Backpack\CRUD\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Visit extends Model
{

    protected $fillable=['dateandtime','address','description','comments','result_id','next_visit','subject_id','attachments'];
    protected $casts=[
        'dateandtime'=>'datetime',
        'attachments'=>'array',
    ];

    protected $appends=['attendanceColumn'];

    use CrudTrait;
    use SoftDeletes;


    public function attendance(){
        return $this->morphMany(Attendance::class,'attendable');
    }

    public function result(){
        return $this->belongsTo(VisitStatus::class,'result_id');
    }

    public function subject(){
        return $this->belongsTo(VisitSubject::class,'subject_id');
    }

    public function delete()
    {
        $res= parent::delete();
        if($res==true){
            $this->attendance()->delete();
        }

        return $res;

    }

    public function getAttendanceColumnAttribute(){
        $total= $this->attendance()->count();
        $first = $this->attendance()->take(3)->get();
        $out="";
        if(count($first)){
            $out='<ul>';
            foreach ($first as $f){
                $out.="<li>".$f->attende->fullname."</li>";
            }
            $out.='</ul>';
        }
        if($total-count($first)>0){
            $out.='<br/> Y '.($total-count($first)).' mas...';
        }
        return $out;
    }
}
