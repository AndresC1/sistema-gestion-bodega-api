<?php

namespace App\Http\Requests\Inventory;

use Illuminate\Foundation\Http\FormRequest;

class TypeInventoryRequest extends FormRequest
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
            'type' => 'required|string|in:MP,PT',
            'is_available' => 'in:true,false|nullable',
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
            'type.required' => 'El tipo de inventario es requerido',
            'type.string' => 'El tipo de inventario debe ser una cadena de caracteres',
            'type.in' => 'El tipo de inventario debe ser MP o PT',
            'is_available.in' => 'El tipo de valor debe ser true o false',
        ];
    }
}
