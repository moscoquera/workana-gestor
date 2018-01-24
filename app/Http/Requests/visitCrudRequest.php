<?php

namespace App\Http\Requests;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class visitCrudRequest extends CrudRequest
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
            'dateandtime'=>'required|date',
            'address'=>'nullable|string|max:250',
            'description'=>'nullable|string|max:250',
            'comments'=>'nullable|string|max:2040',
        ];
    }

    public function attributes()
    {
        return [
          'address'=>'Lugar'
        ];
    }
}
