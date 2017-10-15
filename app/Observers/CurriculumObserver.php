<?php
/**
 * Created by PhpStorm.
 * User: smith
 * Date: 10/15/17
 * Time: 10:55 AM
 */

namespace App\Observers;


use App\Models\Curriculum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CurriculumObserver
{

    protected $request;

    public function __construct(Request $request)
    {
        $this->request=$request;
    }


    public function saved(Curriculum $curriculum){


        $educations = $this->request->input('educations');
        if ($educations){
            $educations=json_decode($educations);
        }else{
            $educations=[];
        }

        $experiences = $this->request->input('experiences');
        if ($experiences){
            $experiences=json_decode($experiences);
        }else{
            $experiences=[];
        }

        $languages = $this->request->input('languages');
        if ($languages){
            $languages=json_decode($languages);
            for ($i=0;$i<sizeof($languages);$i++){
                $language=$languages[$i];
                if(isset($language->proficency)){
                    $languages[$i]=$language->proficency;
                }
            }
        }else{
            $languages=[];
        }



        $references_personal = $this->request->input('personal_references');
        if ($references_personal){
            $references_personal=json_decode($references_personal);
            for ($i=0;$i<sizeof($references_personal);$i++){
                $references_personal[$i]->type='p';
            }
        }else{
            $references_personal=[];
        }

        $references_fam = $this->request->input('familiar_references');
        if ($references_fam){
            $references_fam=json_decode($references_fam);
            for ($i=0;$i<sizeof($references_fam);$i++){
                $references_fam[$i]->type='f';
            }
        }else{
            $references_fam=[];
        }

        $curriculum->setPhotoAttribute($this->request->input('photo'));


        $this->relationSyncFromJson($curriculum,'educations',$educations);
        $this->relationSyncFromJson($curriculum,'experiences',$experiences);
        $this->relationSyncFromJson($curriculum,'languages',$languages,'language_id');
        $this->relationSyncFromJson($curriculum,'personal_references',$references_personal);
        $this->relationSyncFromJson($curriculum,'familiar_references',$references_fam);

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