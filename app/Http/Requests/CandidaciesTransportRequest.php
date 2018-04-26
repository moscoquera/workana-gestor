<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;

class CandidaciesTransportRequest extends CrudRequest
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
	        'requested'=>'nullable|string|max:10000',
	        'given'=>'nullable|string|max:10000',
	        'registered'=>'nullable|integer|min:0',

        ];
    }
}
