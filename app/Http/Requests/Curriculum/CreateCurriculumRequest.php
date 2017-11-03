<?php

namespace App\Http\Requests\Curriculum;

use Backpack\CRUD\app\Http\Requests\CrudRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class CreateCurriculumRequest extends CrudRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return (!Auth::user()->isAdmin() && $this->input('user_id')==Auth::user()->id) || Auth::user()->isAdmin();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        return [
            'user_id'=>'required|exists:users,id',
            'sex'=>'required|string|size:1',
            'document'=>[
                'max:30','required','string',
                Rule::unique('users','username')->ignore($this->input('user_id')),
            ],
            'date_of_birth'=>'required|date_format:Y-m-d',
            'birth_dep_id' => 'required|integer|exists:departments,id',
            'birth_city_id' =>'required|integer|exists:cities,id',
            'nationality_id'=>'required|integer|exists:countries,id',
            'current_address'=>'required|string|min:10|max:512',
            'current_dep_id' => 'required|integer|exists:departments,id',
            'current_city_id' =>'required|integer|exists:cities,id',
            'current_country_id'=>'required|integer|exists:countries,id',
            'phone'=>'required|string|min:3|max:255',
            'mobile'=>'required|string|min:10|max:255',
            'profession_id'=>'required|integer|exists:professions,id',
            'resume'=>'required|string|max:1024',
            'educations'=>'nullable|json',
            'experiences'=>'nullable|json',
            'languages'=>'nullable|json',
            'references_fam'=>'json',
            'references_personal'=>'json',
            'photo'=>'required'
        ];
    }
}
