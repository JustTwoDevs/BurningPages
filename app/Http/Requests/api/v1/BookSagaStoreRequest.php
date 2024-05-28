<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class BookSagaStoreRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100|unique:bookSagas,name',
            'sinopsis' => 'required|string|min:20',
            'order' => 'array|min:1',
            'order.*' => 'integer|min:1',
            'burningmeter' => 'missing',
            'readersScore' => 'missing',
            'books' => 'required|array|min:1',
            'books.*' => 'exists:books,id',
            'cover' => 'string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The name is required.',
            'name.string' => 'The name must be a string.',
            'name.min' => 'The name must be at least 3 characters.',
            'name.max' => 'The name may not be greater than 100 characters.',
            'name.unique' => 'The name has already been taken.',
            'sinopsis.required' => 'The sinopsis is required.',
            'sinopsis.string' => 'The sinopsis must be a string.',
            'sinopsis.min' => 'The sinopsis must be at least 20 characters.',
            'order.array' => 'The order must be an array.',
            'order.min' => 'The order must have at least 1 item.',
            'order.*.integer' => 'The order must be an integer.',
            'burningmeter.missing' => 'The burningmeter cannot be set.',
            'readersScore.missing' => 'The readers score cannot be set.',
            'books.array' => 'The books must be an array.',
            'books.min' => 'The books must have at least 1 item.',
            'books.*.exists' => 'The selected books is invalid.',
            'cover.string' => 'The cover must be a string.',
        ];
    }
}
