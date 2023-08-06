<?php

namespace App\Http\Requests\User;

use App\Rules\User\MatchOrganization;
use App\Rules\User\VerificationRolePermitted;
use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
                'required', 
                'string'
            ],
            'email' => [
                'email', 
                'unique:users'
            ],
            'username' => [
                'required', 
                'string', 
                'unique:users'
            ],
            'role_id' => [
                'required', 
                'integer', 
                'exists:roles,id',
                new VerificationRolePermitted(),
            ],
            'organization_id' => [
                'required', 
                'integer', 
                'exists:organizations,id',
                new MatchOrganization(),
            ],
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'El nombre es requerido',
            'email.email' => 'El email debe ser válido',
            'email.unique' => 'El email ya existe',
            'password.required' => 'La contraseña es requerida',
            'password.min' => 'La contraseña debe tener mínimo 8 caracteres',
            'password.max' => 'La contraseña debe tener máximo 32 caracteres',
            'username.required' => 'El nombre de usuario es requerido',
            'username.unique' => 'El nombre de usuario ya existe',
            'role_id.required' => 'El rol es requerido',
            'role_id.integer' => 'El rol debe ser un número entero',
            'role_id.exists' => 'El rol no existe',
            'organization_id.required' => 'La organización es requerida',
            'organization_id.integer' => 'La organización debe ser un número entero',
            'organization_id.exists' => 'La organización no existe',
        ];
    }
}
