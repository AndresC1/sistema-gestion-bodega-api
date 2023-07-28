<?php

namespace App\Http\Requests\Organization;

// use Illuminate\Contracts\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as Rule;

class UpdateOrganizationRequest extends FormRequest
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
        $id = $this->route('id');
        return [
            "name" => [
                "string",
                Rule::unique('organizations', 'name')->ignore($id, 'id'),
            ],
            "ruc" => [
                "string",
                Rule::unique('organizations', 'ruc')->ignore($id, 'id'),
                "max:14"
            ],
            "address" => "nullable|string",
            "sector_id" => "nullable|integer|exists:sectors,id",
            "municipality_id" => "nullable|integer|exists:municipalities,id",
            "city_id" => "nullable|integer|exists:cities,id",
            "phone_main" => "nullable|string",
            "phone_secondary" => "nullable|string",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array {
        return [
            "name.required" => "El nombre de la organización es requerido",
            "name.string" => "El nombre de la organización debe ser una cadena de caracteres",
            "name.unique" => "El nombre de la organización ya existe",
            "ruc.required" => "El RUC de la organización es requerido",
            "ruc.string" => "El RUC de la organización debe ser una cadena de caracteres",
            "ruc.unique" => "El RUC de la organización ya existe",
            "ruc.max" => "El RUC de la organización debe tener máximo 14 caracteres",
            "address.string" => "La dirección de la organización debe ser una cadena de caracteres",
            "sector_id.integer" => "El sector de la organización debe ser un número entero",
            "sector_id.exists" => "El sector de la organización debe existir en la base de datos",
            "municipality_id.integer" => "El municipio de la organización debe ser un número entero",
            "municipality_id.exists" => "El municipio de la organización debe existir en la base de datos",
            "city_id.integer" => "La ciudad de la organización debe ser un número entero",
            "city_id.exists" => "La ciudad de la organización debe existir en la base de datos",
            "phone_main.string" => "El teléfono principal de la organización debe ser una cadena de caracteres",
            "phone_secondary.string" => "El teléfono secundario de la organización debe ser una cadena de caracteres",
        ];
    }
}
