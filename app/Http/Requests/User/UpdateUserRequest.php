<?php

namespace App\Http\Requests\User;

use App\Rules\MatchOldEmail;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => [
                'string', 
                'max:255',
            ],
            'email' => [
                'email', 
                new MatchOldEmail,
                'unique:users,email',
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no debe ser mayor a 255 caracteres',
            'email.email' => 'El correo electrónico debe ser una dirección de correo electrónico válida',
            'email.unique' => 'El correo electrónico ya está en uso',
        ];
    }
}
