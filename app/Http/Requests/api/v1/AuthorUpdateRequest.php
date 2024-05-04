<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class AuthorUpdateRequest extends FormRequest
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
            'name' => 'string|min:3|max:100',
            'lastname' => 'string|min:3|max:100',
            'pseudonym' => 'string|min:3|max:100|unique:authors,pseudonym',
            'birth_date' => 'date',
            'death_date' => 'nullable|date',
            'biography' => 'string|min:20',
            'nationality_id' => 'exists:nationalities,id',
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'lastname.string' => 'The lastname must be a string.',
            'lastname.min' => 'The lastname must be at least 3 characters.',
            'lastname.max' => 'The lastname may not be greater than 100 characters.',
            'pseudonym.string' => 'The pseudonym must be a string.',
            'pseudonym.min' => 'The pseudonym must be at least 3 characters.',
            'pseudonym.max' => 'The pseudonym may not be greater than 100 characters.',
            'pseudonym.unique' => 'The pseudonym has already been taken.',
            'birth_date.date' => 'The birth date must be a date.',
            'death_date.date' => 'The death date must be a date.',
            'biography.string' => 'The biography must be a string.',
            'biography.min' => 'The biography must be at least 20 characters.',
            'nationality_id.exists' => 'The nationality does not exist.',
            'cover.image' => 'The cover must be an image.',
            'cover.mimes' => 'The cover must be a file of type: jpeg, png, jpg, gif, svg.',
            'cover.max' => 'The cover may not be greater than 2048 kilobytes.',
        ];
    }
}
