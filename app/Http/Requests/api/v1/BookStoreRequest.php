<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class BookStoreRequest extends FormRequest
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
            'title' => 'required|string|min:3|max:100|unique:books,title',
            'sinopsis' => 'required|string|min:20',
            'publication_date' => 'nullable|date',
            'original_language' => 'required|string|min:2|max:2',
            'burningmeter' => 'missing',
            'readersScore' => 'missing',
            'buyLink' => 'required|string|min:20|max:255',
            'authors' => 'array|min:1',
            'authors.*' => 'exists:authors,id',
            'genres' => 'array|min:1',
            'genres.*' => 'exists:genres,id',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The title is required.',
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title may not be greater than 100 characters.',
            'title.unique' => 'The title has already been taken.',
            'sinopsis.required' => 'The sinopsis is required.',
            'sinopsis.string' => 'The sinopsis must be a string.',
            'sinopsis.min' => 'The sinopsis must be at least 20 characters.',
            'publication_date.date' => 'The publication date is not a valid date.',
            'original_language.required' => 'The original language is required.',
            'original_language.string' => 'The original language must be a string.',
            'original_language.min' => 'The original language must be at least 2 characters.',
            'original_language.max' => 'The original language may not be greater than 2 characters.',
            'burningmeter.missing' => 'The burningmeter cannot be set.',
            'readersScore.missing' => 'The readers score cannot be set.',
            'buyLink.required' => 'The buy link is required.',
            'buyLink.string' => 'The buy link must be a string.',
            'buyLink.min' => 'The buy link must be at least 20 characters.',
            'buyLink.max' => 'The buy link may not be greater than 255 characters.',
            'authors.array' => 'The authors must be an array.',
            'authors.min' => 'The authors must have at least 1 item.',
            'authors.*.exists' => 'The selected authors is invalid.',
            'genres.array' => 'The genres must be an array.',
            'genres.min' => 'The genres must have at least 1 item.',
            'genres.*.exists' => 'The selected genres is invalid.',
        ];
    }
}
