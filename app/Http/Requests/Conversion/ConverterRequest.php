<?php

namespace App\Http\Requests\Conversion;

use Illuminate\Foundation\Http\FormRequest;

class ConverterRequest extends FormRequest
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
            'type' => 'required|string|in:Longitud,Masa/Peso,Volumen,Unidad',
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
            'type.required' => 'El tipo de medida es requerido',
            'type.string' => 'El tipo de medida debe ser una cadena de caracteres',
            'type.in' => 'El tipo de medida debe ser Longitud, Masa/Peso, Volumen o Unidad',
        ];
    }
}
