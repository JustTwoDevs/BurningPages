<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRatesUpdateRequest extends FormRequest
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
           
            'value' => 'boolean|nullable',
        ];
    }

    public function messages(): array{
        return [
            'review_id.required' => 'The review id is required.',
            'review_id.exists' => 'The review id must exist in the reviews table.',
            'value.boolean' => 'The rate id must be a boolean.',

        ];
    }
}