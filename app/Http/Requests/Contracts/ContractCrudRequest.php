<?php

namespace App\Http\Requests\Contracts;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ContractCrudRequest extends CrudRequest
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
            'user_id'=>'required|integer|exists:users,id',
            'type_id'=>'required|integer|exists:types,id',
            'start_date'=>'required|date',
            'end_date'=>'required|date|after_or_equal:start_date',
            'description'=>'required|string|max:2000'
        ];
    }
}
