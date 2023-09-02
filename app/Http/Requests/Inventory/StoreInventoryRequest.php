<?php

namespace App\Http\Requests\Inventory;

use App\Rules\Inventory\ValidateCodeExistInTheOrganization;
use App\Rules\Inventory\ValidateExistInTheOrganization;
use App\Rules\Inventory\ValidateUnitMeasurement;
use Illuminate\Foundation\Http\FormRequest;

class StoreInventoryRequest extends FormRequest
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
        $product_id = request('product_id');
        return [
            'product_id' => [
                'required',
                'exists:products,id',
                new ValidateExistInTheOrganization()
            ],
            'type' => 'required|in:MP,PT',
            'stock_min' => 'required|numeric|min:0',
            'unit_of_measurement' => [
                'required',
                'max:3',
                new ValidateUnitMeasurement($product_id)
            ],
            'location' => 'string|max:255|nullable',
            'lot_number' => 'string|max:255|nullable',
            'note' => 'string|max:255|nullable',
            'code' => [
                'string',
                'max:255',
                'nullable',
                new ValidateCodeExistInTheOrganization()
            ],
            'description' => 'string|max:255|nullable',
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
            'product_id.required' => 'El campo product_id es requerido',
            'product_id.exists' => 'El campo product_id debe existir en la tabla products',
            'type.required' => 'El campo type es requerido',
            'type.in' => 'El campo type debe ser MP o PT',
            'stock.required' => 'El campo stock es requerido',
            'stock.numeric' => 'El campo stock debe ser numérico',
            'stock.min' => 'El campo stock debe ser mayor o igual a 0',
            'stock_min.required' => 'El campo stock_min es requerido',
            'stock_min.numeric' => 'El campo stock_min debe ser numérico',
            'stock_min.min' => 'El campo stock_min debe ser mayor o igual a 0',
            'unit_of_measurement.required' => 'El campo unit_of_measurement es requerido',
            'unit_of_measurement.max' => 'El campo unit_of_measurement debe tener máximo 3 caracteres',
            'location.string' => 'El campo location debe ser una cadena de caracteres',
            'location.max' => 'El campo location debe tener máximo 255 caracteres',
            'lot_number.string' => 'El campo lot_number debe ser una cadena de caracteres',
            'lot_number.max' => 'El campo lot_number debe tener máximo 255 caracteres',
            'note.string' => 'El campo note debe ser una cadena de caracteres',
            'note.max' => 'El campo note debe tener máximo 255 caracteres',
            'total_value.required' => 'El campo total_value es requerido',
            'total_value.numeric' => 'El campo total_value debe ser numérico',
            'total_value.min' => 'El campo total_value debe ser mayor o igual a 0',
            'code.string' => 'El campo code debe ser una cadena de caracteres',
            'code.max' => 'El campo code debe tener máximo 255 caracteres',
            'description.string' => 'El campo description debe ser una cadena de caracteres',
            'description.max' => 'El campo description debe tener máximo 255 caracteres',
        ];
    }
}
