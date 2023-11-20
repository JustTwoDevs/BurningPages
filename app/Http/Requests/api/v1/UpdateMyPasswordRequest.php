<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMyPasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'oldPassword' => 'required|string|min:8|max:255',
            'newPassword' => 'required|string|min:8|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'oldPassword.required' => 'La contraseña actual es obligatoria.',
            'oldPassword.string' => 'La contraseña actual debe ser un texto.',
            'oldPassword.min' => 'La contraseña actual debe tener al menos 8 caracteres.',
            'oldPassword.max' => 'La contraseña actual no puede tener más de 255 caracteres.',
            'newPassword.required' => 'La nueva contraseña es obligatoria.',
            'newPassword.string' => 'La nueva contraseña debe ser un texto.',
            'newPassword.min' => 'La nueva contraseña debe tener al menos 8 caracteres.',
            'newPassword.max' => 'La nueva contraseña no puede tener más de 255 caracteres.',
        ];
    }
}
