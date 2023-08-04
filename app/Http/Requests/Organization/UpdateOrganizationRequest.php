<?php

namespace App\Http\Requests\Organization;

// use Illuminate\Contracts\Validation\Rule;

use App\Models\Organization;
use App\Rules\OrganizationRule\MatchBothPhone;
use App\Rules\OrganizationRule\MatchOldAddress;
use App\Rules\OrganizationRule\MatchOldCity;
use App\Rules\OrganizationRule\MatchOldMunicipality;
use App\Rules\OrganizationRule\MatchOldPhoneMain;
use App\Rules\OrganizationRule\MatchOldPhoneSecondary;
use App\Rules\OrganizationRule\MatchOldSector;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule as Rule;

class UpdateOrganizationRequest extends FormRequest
{
    protected $organization;

    public function __construct(Organization $organization)
    {
        $this->organization = $organization;
    }
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
        $organization = $this->route('organization')?? $this->organization;
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
            "address" => [
                "nullable", 
                "string",
                new MatchOldAddress($organization->address)
            ],
            "sector_id" => [
                "nullable", 
                "integer", 
                "exists:sectors,id",
                new MatchOldSector($organization->sector_id)
            ],
            "municipality_id" => [
                "nullable", 
                "integer", 
                "exists:municipalities,id",
                new MatchOldMunicipality($organization->municipality_id)
            ],
            "city_id" => [
                "nullable", 
                "integer", 
                "exists:cities,id",
                new MatchOldCity($organization->city_id)
            ],
            "phone_main" => [
                "nullable", 
                "string",
                new MatchOldPhoneMain($organization->phone_main),
            ],
            "phone_secondary" => [
                "nullable", 
                "string",
                "different:phone_main",
                new MatchOldPhoneSecondary($organization->phone_secondary),
            ],
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
