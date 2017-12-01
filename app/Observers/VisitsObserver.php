<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 10/15/17
 * Time: 10:55 AM
 */

namespace App\Observers;


use App\Models\Curriculum;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VisitsObserver
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request=$request;
    }


    public function saved(Visit $visit)
    {
        $attendance = $this->request->input('attendance');
        if ($attendance){
            $attendance=json_decode($attendance);
            for ($i=0;$i<sizeof($attendance);$i++){
                $attendance[$i]->attende_type='App\Models\PublicUser';
                $attendance[$i]->attended=1;
            }
        }else{
            $attendance=[];
        }
        $this->relationSyncFromJson($visit,'attendance',$attendance,false);
        
    }


    protected function relationSyncFromJson($instance,$relation,$newItems,$pivot=false){

        if ($pivot){
            $newData=[];
            foreach ($newItems as $newItem) {
                if(isset($newItem->{$pivot})){
                    $newData[$newItem->{$pivot}]=(array)$newItem;
                }
            }

            $instance->$relation()->sync($newData);
            return;
        }

        $relationObjectsMaps=$instance->{$relation}->mapWithKeys(function($item){
            return [$item->getKey() => $item];
        });
        foreach($newItems as $newItem){
            if (isset($newItem->id) && $newItem->id){
                $relationObjectsMaps[$newItem->id]->fill((array)$newItem);
                $relationObjectsMaps[$newItem->id]->save();
                unset($relationObjectsMaps[$newItem->id]);
            }else{
                $instance->$relation()->create((array)$newItem);
            }
        }

        foreach ($relationObjectsMaps as $id=>$remaining){
            $remaining->delete();
        }
    }

}