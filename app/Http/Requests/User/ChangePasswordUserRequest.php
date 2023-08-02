<?php

namespace App\Http\Requests\User;

use App\Rules\MatchOldPassword;
use Illuminate\Foundation\Http\FormRequest;

class ChangePasswordUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'old_password' => [
                'required', 
                'string', 
                'min:8', 
                'max:32', 
                new MatchOldPassword
            ],
            'password' => [
                'required',
                'string',
                'min:8',
                'max:32', 
                'different:old_password'
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'password.required' => 'contraseña requerida!',
            'password.string' => 'contraseña debe ser una cadena de caracteres!',
            'password.min' => 'contraseña debe tener al menos 8 caracteres!',
            'password.max' => 'contraseña debe tener máximo 32 caracteres!',
            'password.different' => 'contraseña vieja y nueva deben ser diferentes!',
            'old_password.required' => 'contraseña vieja requerida!',
            'old_password.string' => 'contraseña vieja debe ser una cadena de caracteres!',
            'old_password.min' => 'contraseña vieja debe tener al menos 8 caracteres!',
            'old_password.max' => 'contraseña vieja debe tener máximo 32 caracteres!',
        ];
    }
}
