<?php

namespace App\Http\Requests\Sale;

use App\Rules\Sale\ValidateClientExistInTheOrganization;
use App\Rules\Sale\ValidateNumberBill;
use Illuminate\Foundation\Http\FormRequest;

class StoreSaleRequest extends FormRequest
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
            'client_id' => [
                'required',
                'exists:clients,id',
                new ValidateClientExistInTheOrganization()
            ],
            'number_bill' => [
                'required',
                'numeric',
                'min:0',
                new ValidateNumberBill()
            ],
            'note' => 'nullable|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     */

    public function messages(): array
    {
        return [
            'client_id.required' => 'El campo cliente es requerido.',
            'client_id.exists' => 'El cliente no existe.',
            'number_bill.required' => 'El campo numero de factura es requerido.',
            'number_bill.numeric' => 'El campo numero de factura debe ser numerico.',
            'number_bill.min' => 'El campo numero de factura debe ser mayor a 0.',
            'note.string' => 'El campo nota debe ser una cadena de caracteres.',
            'note.max' => 'El campo nota debe tener maximo 255 caracteres.',
        ];
    }
}
