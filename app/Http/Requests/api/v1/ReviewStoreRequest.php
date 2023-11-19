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
            'rate' => 'numeric',
            'book_id' => 'required|integer|exists:books,id',
            'user_id' => 'required|integer|exists:users,id',
        ];
        
    }
    public function messages():array{
        return [
            'rate.numeric' => 'The rate must be a number.',
            'book_id.required' => 'The book id is required.',
            'book_id.integer' => 'The book id must be an integer.',
            'book_id.exists' => 'The book id must exist in the books table.',
            'user_id.required' => 'The user id is required.',
            'user_id.integer' => 'The user id must be an integer.',
            'user_id.exists' => 'The user id must exist in the users table.',
        ];
    }
}
