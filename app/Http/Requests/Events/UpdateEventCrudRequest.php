<?php

namespace App\Http\Requests\Events;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEventCrudRequest extends CreateEventCrudRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        $rules = parent::rules();
        $rules['status_id'] = ['required',
            'integer',
            Rule::exists('types', 'id')->where(function ($query) {
                return $query->where('type', 'event_status');

            })
        ];

        return $rules;
    }
}
