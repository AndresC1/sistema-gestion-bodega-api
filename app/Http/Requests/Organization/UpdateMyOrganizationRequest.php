<?php

namespace App\Http\Requests\Organization;

use App\Rules\OrganizationRule\MatchOldAddress;
use App\Rules\OrganizationRule\MatchOldCity;
use App\Rules\OrganizationRule\MatchOldMunicipality;
use App\Rules\OrganizationRule\MatchOldPhoneMain;
use App\Rules\OrganizationRule\MatchOldPhoneSecondary;
use App\Rules\OrganizationRule\MatchOldSector;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as Rule;

class UpdateMyOrganizationRequest extends FormRequest
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
            "name" => [
                "string",
                "unique:organizations,name",
            ],
            "ruc" => [
                "string",
                "unique:organizations,ruc",
                "max:14",
                "nullable"
            ],
            "address" => [
                "nullable",
                "string",
            ],
            "sector_id" => [
                "integer",
                "exists:sectors,id",
            ],
            "municipality_id" => [
                "integer",
                "exists:municipalities,id",
            ],
            "city_id" => [
                "integer",
                "exists:cities,id",
            ],
            "phone_main" => [
                "string",
                "nullable"
            ],
            "phone_secondary" => [
                "nullable",
                "string",
                "different:phone_main",
            ],
            "image" => [
                "nullable",
                "image",
                "mimes:jpeg,png,jpg,svg",
                "max:2048"
            ]
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
            "image.image" => "La imagen de la organización debe ser una imagen",
            "image.mimes" => "La imagen de la organización debe ser de tipo jpeg, png, jpg o svg",
            "image.max" => "La imagen de la organización debe pesar máximo 2MB",
        ];
    }
}
