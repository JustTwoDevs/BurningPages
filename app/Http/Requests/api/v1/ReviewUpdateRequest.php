<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ReviewUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'rate' => 'numeric',
            'content' => 'string|max:1000|min:10',
        ];
        
    }
    public function messages():array{
        return [
            'rate.numeric' => 'The rate must be numeric.',
            'content.string' => 'The content must be a string.',
            'content.max' => 'The content must be less than 1000 characters.',
            'content.min' => 'The content must be more than 10 characters.',
        ];
    }
}
