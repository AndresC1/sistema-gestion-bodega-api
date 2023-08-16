<?php

namespace App\Http\Requests\Provider;

use App\Models\Provider;
use App\Rules\Provider\MatchOldAddress;
use App\Rules\Provider\MatchOldCity;
use App\Rules\Provider\MatchOldContactName;
use App\Rules\Provider\MatchOldEmail;
use App\Rules\Provider\MatchOldMunicipality;
use App\Rules\Provider\MatchOldName;
use App\Rules\Provider\MatchOldPhoneMain;
use App\Rules\Provider\MatchOldPhoneSecondary;
use App\Rules\Provider\MatchOldRuc;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProviderRequest extends FormRequest
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
        $data_provider = $this->route('provider');
        return [
            'name' => [
                'string',
                'max:255',
                new MatchOldName($data_provider->name)
            ],
            'email' => [
                'string',
                'email',
                'max:100',
                new MatchOldEmail($data_provider->email)
            ],
            'ruc' => [
                'string',
                'max:14',
                new MatchOldRuc($data_provider->ruc)
            ],
            'municipality_id' => [
                'integer',
                'exists:municipalities,id',
                new MatchOldMunicipality($data_provider->municipality_id)
            ],
            'city_id' => [
                'integer',
                'exists:cities,id',
                new MatchOldCity($data_provider->city_id)
            ],
            'contact_name' => [
                'string',
                'max:100',
                new MatchOldContactName($data_provider->contact_name)
            ],
            'address' => [
                'string',
                'max:255',
                new MatchOldAddress($data_provider->address)
            ],
            'phone_main' => [
                'string',
                'max:255',
                new MatchOldPhoneMain($data_provider->phone_main)
            ],
            'phone_secondary' => [
                'string',
                'max:255',
                new MatchOldPhoneSecondary($data_provider->phone_secondary),
                'different:phone_main'
            ],
            'details' => 'string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */
    public function messages(): array
    {
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
            'municipality_id.required' => 'El municipio del proveedor es requerido',
            'municipality_id.integer' => 'El municipio del proveedor debe ser un número entero',
            'municipality_id.exists' => 'El municipio del proveedor debe existir en la base de datos',
            'city_id.required' => 'La ciudad del proveedor es requerida',
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
            'phone_secondary.different' => 'El teléfono secundario del proveedor debe ser diferente al teléfono principal',
            'details.string' => 'Los detalles del proveedor deben ser una cadena de caracteres',
        ];
    }
}
