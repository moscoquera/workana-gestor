<?php

namespace App\Http\Requests\Users;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;


class CreateUserCrudRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  Auth::user()->rol->id==1;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'=>[
                'max:30','required','string',
                Rule::unique('users')
            ],
            'first_name'=>'required|min:3|max:100',
            'last_name'=>'required|min:3|max:100',
            'email'=>[
                'nullable','max:100','email',
                Rule::unique('users')
            ],
            'date_of_birth'=>'required|date_format:Y-m-d',
            'sex'=>'required|string|size:1',
            'nationality_id'=>'required|integer|exists:countries,id',
            'current_address'=>'required|string|min:10|max:512',
            'current_dep_id' => 'required|integer|exists:departments,id',
            'current_city_id' =>'required|integer|exists:cities,id',
            'current_country_id'=>'required|integer|exists:countries,id',
            'phone'=>'required|string|min:3|max:255',
            'mobile'=>'required|string|min:10|max:255',
            'profession_id'=>'required|integer|exists:professions,id',

        ];
    }

    public function attributes()
    {
        return [
            'username'=>'documento',
        ];
    }




}
