<?php

namespace App\Http\Requests\Purchase;

use App\Rules\Purchase\ValidateProviderExistInTheOrganization;
use Illuminate\Foundation\Http\FormRequest;

class StorePurchaseRequest extends FormRequest
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
            'number_bill' => 'required|string|max:255',
            'provider_id' => [
                'required',
                'integer',
                'exists:providers,id',
                new ValidateProviderExistInTheOrganization()
            ]
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
            'number_bill.string' => 'El número de factura debe ser una cadena de texto',
            'number_bill.max' => 'El número de factura no debe ser mayor a 255 caracteres',
            'provider_id.required' => 'El proveedor es requerido',
            'provider_id.integer' => 'El proveedor debe ser un número entero',
            'provider_id.exists' => 'El proveedor no existe en la base de datos',
            'date.required' => 'La fecha es requerida',
            'date.date' => 'La fecha debe ser una fecha válida'
        ];
    }
}
