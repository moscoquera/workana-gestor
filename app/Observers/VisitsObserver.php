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
        $this->relationSyncFromJson($visit,'attendance',$attendance,false,'attende_id');

    }


    protected function relationSyncFromJson($instance,$relation,$newItems,$pivot=false,$secondKey=false){

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

        $relationObjectsMapSecondKey=[];
        if($secondKey) {
            $relationObjectsMapSecondKey = $instance->{$relation}->mapWithKeys(function ($item) use ($secondKey) {
                return [$item->{$secondKey} => $item];
            });
        }


        foreach($newItems as $newItem){
            if (isset($newItem->id) && $newItem->id){
                $relationObjectsMaps[$newItem->id]->fill((array)$newItem);
                $relationObjectsMaps[$newItem->id]->save();
                unset($relationObjectsMaps[$newItem->id]);
            }elseif($secondKey && isset($newItem->{$secondKey}) && $newItem->{$secondKey}
            &&  isset($relationObjectsMapSecondKey[$newItem->{$secondKey}]))
            {
                $relationObjectsMapSecondKey[$newItem->{$secondKey}]->fill((array)$newItem);
                $relationObjectsMapSecondKey[$newItem->{$secondKey}]->save();
                unset($relationObjectsMaps[$relationObjectsMapSecondKey[$newItem->{$secondKey}]->id]);
            }elseif(isset($newItem->attende_id)){
                $instance->$relation()->create((array)$newItem);
            }
        }

        foreach ($relationObjectsMaps as $id=>$remaining){
            $remaining->delete();
        }
    }

}