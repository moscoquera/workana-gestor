<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CandidaciesCrudRequest extends CrudRequest
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
            'candidate_id'=>'required|integer|exists:candidates,id',
            'proyected_votes'=>'required|integer|min:0',
            'gotten_votes'=>'required|integer|min:0',
            'observation'=>'nullable|string|max:1000',
	        'election_date'=>'required|date',
	        'party_votes'=>'required|integer|min:0',
	        'party_number'=>'required|integer|min:0'
        ];
    }
}
