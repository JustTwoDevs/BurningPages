<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRatesStoreRequest extends FormRequest
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
            'bookReview_id' => 'required|integer|exists:bookReviews,id',
            'value' => 'boolean|nullable',
            'user_id' => 'required|integer|exists:users,id',
        ];
    }

    public function messages(): array{
        return [
            'bookReview_id.required' => 'The review id is required.',
            'bookReview_id.exists' => 'The review id must exist in the reviews table.',
            'value.boolean' => 'The rate id must be a boolean.',
            'user_id.required' => 'The user id is required.',
            'user_id.integer' => 'The user id must be an integer.',
            'user_id.exists' => 'The user id must exist in the users table.',

        ];
    }
}
