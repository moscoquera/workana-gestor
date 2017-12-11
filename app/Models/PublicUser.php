<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\DB;

class PublicUser extends User
{

    protected $table='users';

    protected $fillable = [
        'first_name','last_name', 'email', 'password','rol_id','username','level_id','sex','date_of_birth',
        'nationality_id','current_address','current_dep_id','current_city_id','current_country_id','phone',
        'mobile','profession_id','leader_id','election_address','election_dep_id','election_city_id','town_id','neighborhood_id'
    ];

    protected $appends=[
        'fullname'
    ];


    protected static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub

        static::addGlobalScope('users', function (Builder $builder) {
            $builder->where('rol_id', '=', 2 );
        });
    }


    public function crudDashboard(){
        return '<a href="'.url('users/'.$this->id).'" class="btn btn-xs btn-success"><i class="fa fa-area-chart"></i> Dashboard</a><br/>';
    }

    public function level(){
        return $this->belongsTo(Level::class);
    }

    public function attendanceToEvents(){
        return $this->morphMany(Attendance::class,'attende')->where('attendable_type',Event::class);
    }

    public function getDocumentAttribute(){
        return $this->username;
    }

    public function visits(){
        return $this->morphMany(Attendance::class,'attende')->where('attendable_type',Visit::class);

    }

    public function leader(){
        return $this->belongsTo(PublicUser::class);
    }




}
