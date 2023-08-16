<?php

namespace App\Http\Requests\Client;

use App\Rules\Client\ValidateExistInTheOrganization;
use Illuminate\Foundation\Http\FormRequest;

class StoreClientRequest extends FormRequest
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
            'address' => 'nullable|string|max:255',
            'municipality_id' => 'required|integer|exists:municipalities,id',
            'city_id' => 'required|integer|exists:cities,id',
            'type' => 'required|string|in:Por mayor,Al detalle',
            'phone_main' => 'nullable|string|max:255',
            'phone_secondary' => 'nullable|string|max:255|different:phone_main',
            'details' => 'nullable|string',
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
            'name.required' => 'El nombre es requerido',
            'name.string' => 'El nombre debe ser una cadena de caracteres',
            'name.max' => 'El nombre no debe exceder los 255 caracteres',
            'address.string' => 'La dirección debe ser una cadena de caracteres',
            'address.max' => 'La dirección no debe exceder los 255 caracteres',
            'municipality_id.required' => 'El municipio es requerido',
            'municipality_id.integer' => 'El municipio debe ser un número entero',
            'municipality_id.exists' => 'El municipio seleccionado no existe',
            'city_id.required' => 'La ciudad es requerida',
            'city_id.integer' => 'La ciudad debe ser un número entero',
            'city_id.exists' => 'La ciudad seleccionada no existe',
            'type.required' => 'El tipo de cliente es requerido',
            'type.string' => 'El tipo de cliente debe ser una cadena de caracteres',
            'type.in' => 'El tipo de cliente seleccionado no es válido',
            'phone_main.string' => 'El teléfono principal debe ser una cadena de caracteres',
            'phone_main.max' => 'El teléfono principal no debe exceder los 255 caracteres',
            'phone_secondary.string' => 'El teléfono secundario debe ser una cadena de caracteres',
            'phone_secondary.max' => 'El teléfono secundario no debe exceder los 255 caracteres',
            'details.string' => 'Los detalles deben ser una cadena de caracteres',
            'phone_secondary.different' => 'El teléfono secundario debe ser diferente al teléfono principal',
        ];
    }
}
