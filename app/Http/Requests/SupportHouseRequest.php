<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;

class SupportHouseRequest extends CrudRequest
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
        	'city_id'=>'nullable|integer|exists:cities,id',
            'poll_place'=>'nullable|string|max:500',
	        'address'=>'nullable|string|max:500',
	        'phone'=>'nullable|string|max:30',
	        'contact'=>'nullable|string|max:100',
	        'enter_date'=>'nullable|date'
        ];
    }
}
