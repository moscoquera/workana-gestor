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
            'sex'=>'nullable|string|size:1',
            'document'=>[
                'max:30','required','string',
                Rule::unique('users','username')->ignore($this->input('user_id')),
            ],
            'date_of_birth'=>'nullable|date_format:Y-m-d',
            'birth_dep_id' => 'nullable|integer|exists:departments,id',
            'birth_city_id' =>'nullable|integer|exists:cities,id',
            'nationality_id'=>'nullable|integer|exists:countries,id',
            'current_address'=>'nullable|string|min:10|max:512',
            'current_dep_id' => 'nullable|integer|exists:departments,id',
            'current_city_id' =>'nullable|integer|exists:cities,id',
            'current_country_id'=>'nullable|integer|exists:countries,id',
            'phone'=>'nullable|string|min:3|max:255',
            'mobile'=>'nullable|string|min:10|max:255',
            'profession_id'=>'nullable|integer|exists:professions,id',
            'resume'=>'nullable|string|max:1024',
            'educations'=>'nullable|json',
            'experiences'=>'nullable|json',
            'languages'=>'nullable|json',
            'references_fam'=>'json',
            'references_personal'=>'json',
            'photo'=>'nullable',
            'archive'=>'nullable|string|max:250'
        ];
    }
}
