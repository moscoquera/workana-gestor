<?php

namespace App\Http\Controllers\Api;

use App\Models\Attendance;
use App\Models\PublicUser;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class UserDashboardController extends Controller
{


    public function visit_attendance(PublicUser $user){
        $query = $user->visits()->with('visit');
        return DataTables::eloquent($query)
            ->addColumn('dateandtime',function(Attendance $attendance){
                return str_limit($attendance->visit->dateandtime->format('Y-m-d H:i'), 30, '...');
            })->addColumn('attended',function(Attendance $attendance){
                return $attendance->attended?'Si':'No';
            })->addColumn('address',function(Attendance $attendance){
                return str_limit($attendance->visit->address, 100, '...');
            })->addColumn('description',function(Attendance $attendance){
                return str_limit($attendance->visit->description, 30, '...');
            })->addColumn('comment',function(Attendance $attendance){
                return str_limit($attendance->visit->comment, 30, '...');
            })->orderColumn('dateandtime','-visit.dateandtime  $1')
            ->make();
    }

    public function event_attendance(PublicUser $user){
        $query = $user->attendanceToEvents()->with('event');
        return DataTables::eloquent($query)
            ->addColumn('dateandtime',function(Attendance $attendance){
                return str_limit($attendance->event->dateandtime->format('Y-m-d H:i'), 30, '...');
            })->addColumn('attended',function(Attendance $attendance){
                return $attendance->attended?'Si':'No';
            })->addColumn('address',function(Attendance $attendance){
                return str_limit($attendance->event->address, 100, '...');
            })->addColumn('name',function(Attendance $attendance){
                return str_limit($attendance->event->name, 100, '...');
            })->orderColumn('dateandtime','-event.dateandtime  $1')
            ->make();
    }

}
