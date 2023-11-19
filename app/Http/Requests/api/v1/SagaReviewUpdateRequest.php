<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class SagaReviewUpdateRequest extends FormRequest
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
            'bookSaga_id' => 'required|integer|exists:bookSagas,id',
            'user_id' => 'required|integer|exists:users,id',
            'content' => 'required|string|max:1000|min:10',
            'state' => 'required|string|in:draft,published,hidden',
            'rate' => 'required|numeric|between:1,5',
        ];
        
    }
    public function messages():array{
        return [
            'bookSaga_id.required' => 'The bookSaga id is required.',
            'bookSaga_id.integer' => 'The bookSaga id must be an integer.',
            'bookSaga_id.exists' => 'The bookSaga id must exist in the bookSagas table.',
            'user_id.required' => 'The user id is required.',
            'user_id.integer' => 'The user id must be an integer.',
            'user_id.exists' => 'The user id must exist in the users table.',
            'content.required' => 'The content is required.',
            'content.string' => 'The content must be a string.',
            'content.max' => 'The content must be less than 1000 characters.',
            'content.min' => 'The content must be more than 10 characters.',
            'state.required' => 'The state is required.',
            'state.string' => 'The state must be a string.',
            'state.in' => 'The available states are draft, published and hidden.',
            'rate.required' => 'The rate is required.',
            'rate.numeric' => 'The rate must be a numeric.',
            'rate.between' => 'The rate must be between 1 and 5.',
        ];
    }
}
