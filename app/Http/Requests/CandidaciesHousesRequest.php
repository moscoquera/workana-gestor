<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;

class CandidaciesHousesRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
	        'candidacy_id'=>'required|integer|exists:candidacies,id',
	        'support_house_id'=>'required|integer|exists:support_houses,id',
	        'registered'=>'required|integer|min:0',
	        'controlled'=>'required|integer|min:0',
	        'manual'=>'required|integer|min:0',

        ];
    }
}
