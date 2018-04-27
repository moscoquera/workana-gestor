<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ElectionCityResultsRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->isAdmin();
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
            'city_id'=>'required|integer|exists:cities,id',
            'votes'=>'required|integer|min:0',
            'inscribed'=>'nullable|integer|min:0',
            'registered'=>'nullable|integer|min:0',
            'effectivity'=>'nullable|string|max:1000',
        ];
    }
}
