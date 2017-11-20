<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class tempUserCrudRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'document'=>'required|string|max:50',
            'first_name'=>'required|string|max:100',
            'last_name'=>'required|string|max:100',
            'email'=>'nullable|string|max:100',
            'address'=>'required|string|max:255',
            'phone'=>'nullable|string|max:100',
        ];
    }
}
