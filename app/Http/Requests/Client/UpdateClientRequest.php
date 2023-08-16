<?php

namespace App\Http\Requests\Client;

use App\Rules\Client\MatchOldAddress;
use App\Rules\Client\MatchOldCity;
use App\Rules\Client\MatchOldDetails;
use App\Rules\Client\MatchOldMunicipality;
use App\Rules\Client\MatchOldName;
use App\Rules\Client\MatchOldPhoneMain;
use App\Rules\Client\MatchOldPhoneSecondary;
use App\Rules\Client\MatchOldType;
use Illuminate\Foundation\Http\FormRequest;

class UpdateClientRequest extends FormRequest
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
        $client = $this->route('client');
        return [
            'name' => [
                'string',
                'max:255',
                new MatchOldName($client->name)
            ],
            'address' => [
                'nullable',
                'string',
                'max:255',
                new MatchOldAddress($client->address)
            ],
            'municipality_id' => [
                'integer',
                'exists:municipalities,id',
                new MatchOldMunicipality($client->municipality_id)
            ],
            'city_id' => [
                'integer',
                'exists:cities,id',
                new MatchOldCity($client->city_id)
            ],
            'type' => [
                'string',
                'in:Por mayor,Al detalle',
                new MatchOldType($client->type)
            ],
            'phone_main' => [
                'nullable',
                'string',
                'max:255',
                new MatchOldPhoneMain($client->phone_main)
            ],
            'phone_secondary' => [
                'nullable',
                'string',
                'max:255',
                'different:phone_main',
                new MatchOldPhoneSecondary($client->phone_secondary)
            ],
            'details' => [
                'nullable',
                'string',
                'max:255',
                new MatchOldDetails($client->details)
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
            'name.string' => 'El nombre debe de ser una cadena de caracteres',
            'name.max' => 'El nombre no debe de exceder los 255 caracteres',
            'address.string' => 'La dirección debe de ser una cadena de caracteres',
            'address.max' => 'La dirección no debe de exceder los 255 caracteres',
            'municipality_id.integer' => 'La municipalidad debe de ser un número entero',
            'municipality_id.exists' => 'La municipalidad debe de existir en la base de datos',
            'city_id.integer' => 'La ciudad debe de ser un número entero',
            'city_id.exists' => 'La ciudad debe de existir en la base de datos',
            'type.string' => 'El tipo debe de ser una cadena de caracteres',
            'type.in' => 'El tipo debe de ser Por mayor o Al detalle',
            'phone_main.string' => 'El teléfono principal debe de ser una cadena de caracteres',
            'phone_main.max' => 'El teléfono principal no debe de exceder los 255 caracteres',
            'phone_secondary.string' => 'El teléfono secundario debe de ser una cadena de caracteres',
            'phone_secondary.max' => 'El teléfono secundario no debe de exceder los 255 caracteres',
            'phone_secondary.different' => 'El teléfono secundario debe de ser diferente al principal',
            'details.string' => 'Los detalles deben de ser una cadena de caracteres',
            'details.max' => 'Los detalles no deben de exceder los 255 caracteres',
        ];
    }
}
