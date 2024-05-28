<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class SagaReviewStoreRequest extends FormRequest {
    /**
    * Determine if the user is authorized to make this request.
    */

    public function authorize(): bool {
        return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
    */

    public function rules(): array {
        return [
          
            'content' => 'required|string|max:1000|min:10',
            'rate' => 'numeric|between:1,5',
        ];

    }

    public function messages():array {
        return [
           
            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',
            'content.max' => 'The content must be less than 1000 characters.',
            'content.min' => 'The content must be more than 10 characters.',
            'rate.numeric' => 'The rate must be a numeric.',
            'rate.between' => 'The rate must be between 1 and 5.',
        ];
    }
}
