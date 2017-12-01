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
            for($i=0;$i<sizeof($educations);$i++){
                if(!isset($educations[$i]->completion_year) || !$educations[$i]->completion_year){
                    $educations[$i]->completion_year=null;
                }
            }
        }else{
            $educations=[];
        }

        $experiences = $this->request->input('experiences');
        if ($experiences){
            $experiences=json_decode($experiences);
            for($i=0;$i<sizeof($experiences);$i++){
                if(!isset($experiences[$i]->start_date) || !$experiences[$i]->start_date){
                    $experiences[$i]->start_date=null;
                }
                if(!isset($experiences[$i]->end_date) || !$experiences[$i]->end_date){
                    $experiences[$i]->end_date=null;
                }
                if (isset($experiences[$i]->company_id) && is_object($experiences[$i]->company_id)){
                    $experiences[$i]->company_id=$experiences[$i]->company_id->id;
                }

                if (isset($experiences[$i]->sector_id) && is_object($experiences[$i]->sector_id)){
                    $experiences[$i]->sector_id=$experiences[$i]->sector_id->id;
                }
            }
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
        $curriculum->setDocumentAttribute($this->request->input('document'));

        $curriculum->user->profession_id=$this->request->input('profession_id');
        $curriculum->user->sex=$this->request->input('sex');
        $curriculum->user->date_of_birth=$this->request->input('date_of_birth');
        $curriculum->user->nationality_id=$this->request->input('nationality_id');
        $curriculum->user->current_address=$this->request->input('current_address');
        $curriculum->user->current_dep_id=$this->request->input('current_dep_id');
        $curriculum->user->current_city_id=$this->request->input('current_city_id');
        $curriculum->user->current_country_id=$this->request->input('current_country_id');
        $curriculum->user->phone=$this->request->input('phone');
        $curriculum->user->mobile=$this->request->input('mobile');
        $curriculum->user->save();

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