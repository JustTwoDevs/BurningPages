<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class BookSagaUpdateRequest extends FormRequest
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
            'name' => 'string|min:3|max:100|unique:bookSagas,name',
            'sinopsis' => 'string|min:20',
            'order' => 'missing',
            'burningmeter' => 'missing',
            'readersScore' => 'missing',
            'books' => 'missing',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least 3 characters.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'name.unique' => 'The name has already been taken.',
            'sinopsis.string' => 'The sinopsis must be a string.',
            'sinopsis.min' => 'The sinopsis must be at least 20 characters.',
            'order.missing' => 'The order cannot be updated. For this, use the addBook and removeBook endpoints.',
            'burningmeter.missing' => 'The burningmeter cannot be updated.',
            'readersScore.missing' => 'The readers score cannot be updated.',
            'books.missing' => 'The books cannot be updated. For this, use the addBook and removeBook endpoints.',
        ];
    }
}
