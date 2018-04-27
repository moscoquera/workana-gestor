<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 10/15/17
 * Time: 10:55 AM
 */

namespace App\Observers;


use App\Models\Curriculum;
use App\Models\ElectionUser;
use App\Models\Visit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ElectionSupportObserver
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request=$request;
    }


    public function saved(ElectionUser $support)
    {
    	return //disabled
        $credits = $this->request->input('credits');
        $debits = $this->request->input('debits');
        if ($credits){
            $credits=json_decode($credits);
            for ($i=0;$i<sizeof($credits);$i++){
                $credits[$i]->type=1;
                if(!isset($credits[$i]->value)){
                    $credits[$i]->value=0;
                }
                if(!isset($credits[$i]->date)){
                    unset($credits[$i]);
                }
            }
        }else{
            $credits=[];
        }

        if ($debits){
            $debits=json_decode($debits);
            for ($i=0;$i<sizeof($debits);$i++){
                $debits[$i]->type=0;
                if(!isset($debits[$i]->value)){
                    $debits[$i]->value=0;
                }
                if(!isset($debits[$i]->date)){
                    unset($debits[$i]);
                }
            }
        }else{
            $debits=[];
        }

        $this->relationSyncFromJson($support,'credits',$credits,false);
        $this->relationSyncFromJson($support,'debits',$debits,false);

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