<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class BookUpdateRequest extends FormRequest
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
            'title' => 'string|min:3|max:100|unique:books,title',
            'sinopsis' => 'string|min:20',
            'publication_date' => 'date',
            'original_language' => 'string|min:2|max:2',
            'buyLink' => 'string|min:20|max:255',
            'burningmeter' => 'missing',
            'readersScore' => 'missing',
            'authors' => 'missing',
            'genres' => 'missing',
            'cover' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'title.string' => 'The title must be a string.',
            'title.min' => 'The title must be at least 3 characters.',
            'title.max' => 'The title may not be greater than 100 characters.',
            'title.unique' => 'The title has already been taken.',
            'sinopsis.string' => 'The sinopsis must be a string.',
            'sinopsis.min' => 'The sinopsis must be at least 20 characters.',
            'publication_date.date' => 'The publication date is not a valid date.',
            'original_language.string' => 'The original language must be a string.',
            'original_language.min' => 'The original language must be at least 2 characters.',
            'original_language.max' => 'The original language may not be greater than 2 characters.',
            'buyLink.string' => 'The buy link must be a string.',
            'buyLink.min' => 'The buy link must be at least 20 characters.',
            'buyLink.max' => 'The buy link may not be greater than 255 characters.',
            'burningmeter.missing' => 'The burningmeter cannot be updated.',
            'readersScore.missing' => 'The readers score cannot be updated.',
            'authors.missing' => 'The authors cannot be updated. For this, use the addAuthor and removeAuthor endpoints.',
            'genres.missing' => 'The genres cannot be updated. For this, use the addGenre and removeGenre endpoints.',
            'cover.image' => 'The cover must be an image.',
            'cover.mimes' => 'The cover must be a file of type: jpeg, png, jpg, gif, svg.',
            'cover.max' => 'The cover may not be greater than 2048 characters.',
        ];
    }
}
