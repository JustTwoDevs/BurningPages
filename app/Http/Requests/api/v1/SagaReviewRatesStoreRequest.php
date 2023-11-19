<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class SagaReviewRatesStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true ;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'sagaReview_id' => 'required|integer|exists:saga_reviews,id',
            'user_id' => 'required|integer|exists:users,id',
            'value' => 'boolean|nullable',
        ];
        
    }
    public function messages():array{
        return [
            'sagaReview_id.required' => 'The sagaReview id is required.',
            'sagaReview_id.exists' => 'The sagaReview id must exist in the sagaReviews table.',
            'value.boolean' => 'The rate id must be a boolean.',
            'user_id.required' => 'The user id is required.',
            'user_id.exists' => 'The user id must exist in the users table.',
            

        ];
    }
}
