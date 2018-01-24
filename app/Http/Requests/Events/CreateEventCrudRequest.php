<?php

namespace App\Http\Requests\Events;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class CreateEventCrudRequest extends CrudRequest
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
            'name'=>'required|string|max:191',
            'type_id'=>['required',
                        'integer',
                        Rule::exists('types','id')->where(function($query){
                            return $query->where('type','event');

                        }),
                        ],
            'dateandtime'=>'required|date_format:Y-m-d H:i:s',
            'city_id'=>'required|integer|exists:cities,id',
            'address'=>'required|string|max:191',
            'observations'=>'nullable|string|max:2000',
            'user_id'=>'required|integer|exists:users,id',
            'place_name'=>'nullable|string|max:100',
            'controlled'=>'boolean'
        ];
    }
}
