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
            'first_name'=>'required|min:5|max:100',
            'last_name'=>'required|min:5|max:100',
            'email'=>[
                'nullable','max:100','email',
                Rule::unique('users')
            ],
        ];
    }

    public function attributes()
    {
        return [
            'username'=>'documento',
        ];
    }




}
