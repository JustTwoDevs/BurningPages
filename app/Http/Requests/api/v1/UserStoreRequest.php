<?php

namespace App\Http\Requests\api\v1;

use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name' => 'required|string|alpha:ascii|max:255|min:1',
            'lastname' => 'required|string|alpha:ascii|max:255|min:1',
            'username' => 'required|string|alpha_dash:ascii|max:80|min:7|unique:users,username',
            'email' => 'required|email|min:8|max:255|unique:users,email',
            'nationality' => 'required|exists:nationalities,id',
            'birthdate' => 'required|date_format:Y-m-d',
            'password' => 'required|string|min:8|max:255',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.alpha' => 'El nombre debe contener caracteres alfabeticos',
            'name.max' => 'El nombre debe contener como maximo de 255 caracteres',
            'name.min' => 'El nombre debe contener al menos 1 caracter',
            'lastname.required' => 'El apellido es requerido',
            'lastname.string' => 'El apellido debe ser una cadena de caracteres',
            'lastname.alpha' => 'El apellido debe contener caracteres alfabeticos',
            'lastname.max' => 'El apellido debe contener como maximo de 255 caracteres',
            'lastname.min' => 'El apellido debe contener al menos 1 caracter',
            'username.required' => 'El nombre de usuario es requerido',
            'username.string' => 'El nombre de usuario debe ser una cadena de caracteres',
            'username.alpha_dash' => 'El nombre de usuario debe contener caracteres alfabeticos guiones y guiones bajos',
            'username.max' => 'El nombre de usuario debe contener menos de 80 caracteres',
            'username.min' => 'El nombre de usuario debe contener al menos 7 caracteres',
            'email.required' => 'El correo electronico es requerido',
            'email.email' => 'El correo electronico debe ser una direccion de correo valida',
            'email.min' => 'El correo electronico debe contener al menos 8 caracteres',
            'email.max' => 'El correo electronico debe contener menos de 255 caracteres',
            'email.unique' => 'El correo electronico ya esta en uso',
            'nationality.required' => 'La nacionalidad es requerida',
            'nationality.exists' => 'La nacionalidad no existe',
            'birthdate.required' => 'La fecha de nacimiento es requerida',
            'birthdate.date_format' => 'La fecha de nacimiento debe tener el formato Y-m-d',
            'password.required' => 'La contraseña es requerida',
            'password.string' => 'La contraseña debe ser una cadena de caracteres',
            'password.min' => 'La contraseña debe contener al menos 8 caracteres',
            'password.max' => 'La contraseña debe contener menos de 255 caracteres',
        ];
    }
}
