<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ReviewStoreRequest extends FormRequest
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

            'content' => 'required|string',
            'rate' => 'numeric',
        ];
    }

    public function messages():array{
        return [
            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',
            'rate.numeric' => 'The rate must be a number.',
        ];
    }
}
