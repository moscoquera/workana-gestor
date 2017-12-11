<?php

namespace App\Http\Requests;
use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Support\Facades\Auth;

class TownCrudRequest extends CrudRequest
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
            'city_id'=>'required|integer|exists:cities,id',
            'name'=>'required|string|max:100'
        ];
    }
}
