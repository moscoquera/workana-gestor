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
            'election_id'=>'required|integer|exists:elections,id',
            'user_id'=>'required|integer|exists:users,id',
            'proyected_votes'=>'nullable|integer|min:0',
            'registered_votes'=>'nullable|integer|min:0',
            'controlled_votes'=>'nullable|integer|min:0',
            'identified_votes'=>'nullable|integer|min:0',
            'transport_requeriment'=>'nullable|string|max:1000',
            'transport_cost'=>'nullable|integer|min:0',
            'refreshments'=>'nullable|integer|min:0',
            'kit'=>'nullable|boolean',
            'payroll'=>'nullable|boolean',
            'payment'=>'nullable|integer|min:0',
            'number_of_payments'=>'nullable|integer|min:0',
            'house_support'=>'nullable|boolean',
            'activity_id'=>'required|integer|exists:types,id',
            'credits'=>'nullable|json',
            'debits'=>'nullable|json'

        ];
    }
}
