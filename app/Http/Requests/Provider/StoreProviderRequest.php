<?php

namespace App\Http\Requests\Provider;

use App\Rules\Provider\ValidateExistInTheOrganization;
use Illuminate\Foundation\Http\FormRequest;

class StoreProviderRequest extends FormRequest
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
                'string',
                'max:255',
                new ValidateExistInTheOrganization()
            ],
            'email' => 'string|email|max:100',
            'ruc' => 'required|string|max:14',
            'municipality_id' => 'required|integer|exists:municipalities,id',
            'city_id' => 'required|integer|exists:cities,id',
            'contact_name' => 'string|max:100',
            'address' => 'string|max:255',
            'phone_main' => 'string|max:255',
            'phone_secondary' => 'string|max:255',
            'details' => 'string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array {
        return [
            'name.required' => 'El nombre del proveedor es requerido',
            'name.string' => 'El nombre del proveedor debe ser una cadena de caracteres',
            'name.max' => 'El nombre del proveedor debe tener máximo 255 caracteres',
            'email.string' => 'El correo electrónico del proveedor debe ser una cadena de caracteres',
            'email.email' => 'El correo electrónico del proveedor debe ser una dirección de correo electrónico válida',
            'email.max' => 'El correo electrónico del proveedor debe tener máximo 100 caracteres',
            'ruc.required' => 'El RUC del proveedor es requerido',
            'ruc.string' => 'El RUC del proveedor debe ser una cadena de caracteres',
            'ruc.max' => 'El RUC del proveedor debe tener máximo 14 caracteres',
            'municipality_id.integer' => 'El municipio del proveedor debe ser un número entero',
            'municipality_id.exists' => 'El municipio del proveedor debe existir en la base de datos',
            'city_id.integer' => 'La ciudad del proveedor debe ser un número entero',
            'city_id.exists' => 'La ciudad del proveedor debe existir en la base de datos',
            'contact_name.string' => 'El nombre del contacto del proveedor debe ser una cadena de caracteres',
            'contact_name.max' => 'El nombre del contacto del proveedor debe tener máximo 100 caracteres',
            'address.string' => 'La dirección del proveedor debe ser una cadena de caracteres',
            'address.max' => 'La dirección del proveedor debe tener máximo 255 caracteres',
            'phone_main.string' => 'El teléfono principal del proveedor debe ser una cadena de caracteres',
            'phone_main.max' => 'El teléfono principal del proveedor debe tener máximo 255 caracteres',
            'phone_secondary.string' => 'El teléfono secundario del proveedor debe ser una cadena de caracteres',
            'phone_secondary.max' => 'El teléfono secundario del proveedor debe tener máximo 255 caracteres',
            'details.string' => 'Los detalles del proveedor deben ser una cadena de caracteres',
        ];
    }
}
