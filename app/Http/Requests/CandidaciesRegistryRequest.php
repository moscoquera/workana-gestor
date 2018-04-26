<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;

class CandidaciesRegistryRequest extends CrudRequest
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
	        'registered'=>'required|integer|min:0',
	        'controlled'=>'required|integer|min:0',
	        'manual'=>'required|integer|min:0',
	        'precounted'=>'required|integer|min:0',
	        'final'=>'required|integer|min:0',
	        'effectivity'=>'nullable|string|min:10000',
	        'visited'=>'required|integer|min:0',
	        'trained'=>'required|integer|min:0',
        ];
    }
}
