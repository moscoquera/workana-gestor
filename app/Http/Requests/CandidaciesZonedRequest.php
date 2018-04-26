<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;

class CandidaciesZonedRequest extends CrudRequest
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
	        'total'=>'required|integer|min:0',
            'without_incidence'=>'required|integer|min:0',
            'with_incidence'=>'required|integer|min:0',
            'proyected'=>'required|integer|min:0',
            'percentage'=>'required|numeric|min:0,max:100',
        ];
    }
}
