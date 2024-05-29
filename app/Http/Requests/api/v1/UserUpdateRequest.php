<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UserUpdateRequest extends FormRequest
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
            'name' => 'string|max:255|min:1',
            'lastname' => 'string|max:255|min:1',
            'username' => 'string|max:80|min:7|unique:users,username',
            'email' => 'email|min:8|max:255|unique:users,email',
            'nationality_id' => 'exists:nationalities,id',
            'birthdate' => 'date_format:Y-m-d',
            'password' => 'missing',
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre debe contener como maximo de 255 caracteres',
            'name.min' => 'El nombre debe contener al menos 1 caracter',
            'lastname.string' => 'El apellido debe ser una cadena de caracteres',
            'lastname.max' => 'El apellido debe contener como maximo de 255 caracteres',
            'lastname.min' => 'El apellido debe contener al menos 1 caracter',
            'username.string' => 'El nombre de usuario debe ser una cadena de caracteres',
            'username.max' => 'El nombre de usuario debe contener menos de 80 caracteres',
            'username.min' => 'El nombre de usuario debe contener al menos 7 caracteres',
            'email.email' => 'El correo electronico debe ser una direccion de correo valida',
            'email.min' => 'El correo electronico debe contener al menos 8 caracteres',
            'email.max' => 'El correo electronico debe contener menos de 255 caracteres',
            'email.unique' => 'El correo electronico ya esta en uso',
            'nationality_id.exists' => 'La nacionalidad no existe',
            'birthdate.date' => 'La fecha de nacimiento debe tener un formato valido',
            'password.missing' => 'La contraseña no puede ser actualizada desde este recurso',
        ];
    }
}
