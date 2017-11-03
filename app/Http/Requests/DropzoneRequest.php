<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;

class DropzoneRequest extends FormRequest
{
    public function authorize()
    {
        return \Auth::check();
    }

    public function rules()
    {
        return [
            'file' => 'required|file|max:2050|mimetypes:image/bmp,image/jpeg,image/png,application/pdf',
        ];
    }

    public function messages()
    {
        return [
            'file.required' => 'No file specified.',
            'file.image' => 'Not a valid image.',
        ];
    }
}