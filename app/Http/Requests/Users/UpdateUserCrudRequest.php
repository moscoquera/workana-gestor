<?php

namespace App\Http\Requests\Users;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;



class UpdateUserCrudRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return  Auth::user()->rol->id==1 || Auth::user()->id == $this->input('id');
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
                Rule::unique('users')->ignore($this->input('id')),
            ],
            'first_name'=>'required|max:100',
            'last_name'=>'required|max:100',
            'email'=>[
                'nullable','max:100','email',
                Rule::unique('users','email')->ignore($this->input('id')),
            ],

            'password'=>'required_if:passwordchange,1|nullable|string|min:6|confirmed',
            'email2'=>[
                'nullable','max:100','email',
                Rule::unique('users')
            ],
            'date_of_birth'=>'nullable|date_format:Y-m-d',
            'sex'=>'nullable|string|size:1',
            'nationality_id'=>'nullable|integer|exists:countries,id',
            'current_address'=>'nullable|string|min:10|max:512',
            'current_dep_id' => 'nullable|integer|exists:departments,id',
            'current_city_id' =>'nullable|integer|exists:cities,id',
            'current_country_id'=>'nullable|integer|exists:countries,id',
            'phone'=>'nullable|string|min:3|max:255',
            'mobile'=>'nullable|string|min:10|max:255',
            'mobile2'=>'nullable|string|min:10|max:255',
            'profession_id'=>'nullable|integer|exists:professions,id',



        ];
    }
}
