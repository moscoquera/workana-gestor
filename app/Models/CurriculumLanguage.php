<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class CurriculumLanguage extends Pivot
{

    public function getWritingLabelAttribute(){
        $out='';
        switch($this->writing){
            case 0: $out='Bajo';break;
            case 1: $out='Medio';break;
            case 2: $out='Alto';break;
            case 3: $out='Nativo';break;
        }
        return $out;
    }

    public function getSpeakingLabelAttribute(){
        $out='';
        switch($this->writing){
            case 0: $out='Bajo';break;
            case 1: $out='Medio';break;
            case 2: $out='Alto';break;
            case 3: $out='Nativo';break;
        }
        return $out;
    }

}
