<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Experience extends Model
{

    protected $fillable=['curriculum_id','currently','company','boss','phone','start_date','end_date','retirement','functions_in_charge','company_id','sector_id'];

    protected $casts=[
        'currently'=>'boolean',
        'company_id'=>'integer'
    ];

    public function scopeCurrently($query)
    {
        return $query->where('currently',1);
    }

    public function company(){
        return $this->belongsTo('App\Models\Company');
    }

    public function scopePublic($query){
        return $query->whereExists(function($inner){
            return $inner->select(DB::raw(1))->from('types')
                ->where('type','company_sector')->where('name','Público')
                ->whereRaw('types.id = experiences.sector_id');
        });
    }

    public function scopePrivate($query){
        return $query->whereExists(function($inner){
            return $inner->select(DB::raw(1))->from('types')
                ->where('type','company_sector')->where('name','Privado')
                ->whereRaw('types.id = experiences.sector_id');
        });
    }

}
