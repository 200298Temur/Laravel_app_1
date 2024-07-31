<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    public function attributes(): array
    {
        return [
            'title' => 'Sarlavha',
            'short_content' => 'Qisqa mazmun',
            'content' => 'Maqola',
            'photo' => 'File'
        ];
    }
    
    public function messages(): array
    {
        return [
            'title.required' => 'Sarlavha majburiy maydon.',
            'title.max' => 'Sarlavha 255 ta belgidan oshmasligi kerak.',
            'short_content.required' => 'Qisqa mazmun majburiy maydon.',
            'content.required' => 'Maqola majburiy maydon.',
            'photo.required' => 'File majburiy maydon.'
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'title' => 'required|max:255',
            'short_content' => 'required',
            'content' => 'required' ,
            'photo' => 'nullable | image | max:2048' 
        ];
    }
}
