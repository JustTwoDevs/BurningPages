<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class AuthorStoreRequest extends FormRequest
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
            'name' => 'required|string|min:3|max:100',
            'lastname' => 'required|string|min:3|max:100',
            'pseudonym' => 'required|string|min:3|max:100|unique:authors,pseudonym',
            'birth_date' => 'required|date_format:Y-m-d',
            'death_date' => 'nullable|date_format:Y-m-d',
            'biography' => 'required|string|min:20',
            'nationality_id' => 'required|exists:nationalities,id',
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
            'lastname.required' => 'The lastname is required.',
            'lastname.string' => 'The lastname must be a string.',
            'lastname.min' => 'The lastname must be at least 3 characters.',
            'lastname.max' => 'The lastname may not be greater than 100 characters.',
            'pseudonym.required' => 'The pseudonym is required.',
            'pseudonym.string' => 'The pseudonym must be a string.',
            'pseudonym.min' => 'The pseudonym must be at least 3 characters.',
            'pseudonym.max' => 'The pseudonym may not be greater than 100 characters.',
            'pseudonym.unique' => 'The pseudonym has already been taken.',
            'birth_date.required' => 'The birth date is required.',
            'birth_date.date_format' => 'The birth date must be in the format YYYY-MM-DD.',
            'death_date.date_format' => 'The death date must be in the format YYYY-MM-DD.',
            'biography.required' => 'The biography is required.',
            'biography.string' => 'The biography must be a string.',
            'biography.min' => 'The biography must be at least 20 characters.',
            'nationality_id.required' => 'The nationality is required.',
            'nationality_id.exists' => 'The nationality does not exist.',
            'cover.string' => 'The cover must be a string.',
        ];
    }
}
