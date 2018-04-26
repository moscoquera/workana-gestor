<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class CandidateCrudRequest extends CrudRequest
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
            'first_name'=>'required|string|max:100',
	        'last_name'=>'required|string|max:100',
	        'document'=>'required|string|max:20',
	        'department_id'=>'nullable|integer|exists:departments,id',
	        'city_id'=>'nullable|integer|exists:cities,id',
	        'address'=>'nullable|string|max:250',
	        'phone'=>'nullable|string|max:30',
            'phone_alt'=>'nullable|string|max:30',
            'photo'=>'nullable',
	        'profession_id'=>'nullable|integer|exists:professions,id',
	        'enter_date'=>'nullable|date'
        ];
    }
}
