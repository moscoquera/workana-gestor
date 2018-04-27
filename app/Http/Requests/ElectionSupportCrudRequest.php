<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ElectionSupportCrudRequest extends CrudRequest
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
            'candidacy_id'=>'required|integer|exists:candidacies,id',
            'user_id'=>'required|integer|exists:users,id',
            'zoned'=>'nullable|integer|min:0',
            'registered'=>'nullable|integer|min:0',
            'controlled'=>'nullable|integer|min:0',
            'bonuses'=>'nullable|string|max:1000',
            'kit'=>'nullable|boolean',
            'payroll'=>'nullable|integer|min:0',
            'payment'=>'nullable|integer|min:0',
            'number_of_payments'=>'nullable|integer|min:0',
            'house_support'=>'nullable|boolean',
            'transport_requeriment'=>'nullable|string|max:10000',



        ];
    }
}
