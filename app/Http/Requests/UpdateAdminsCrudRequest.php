<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use Illuminate\Validation\Rule;

class UpdateAdminsCrudRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check() && Auth::user()->rol->id==1;
    }



    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'first_name'=>'required|min:5|max:100',
            'last_name'=>'required|min:5|max:100',
            'email'=>[
                'required','max:100','email',
                Rule::unique('users')->ignore($this->input('id'))
            ],

            'password'=>'required_if:passwordchange,1|nullable|string|min:6|confirmed'

        ];
    }
}
