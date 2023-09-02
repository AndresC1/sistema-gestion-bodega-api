<?php

namespace App\Http\Requests\Product;

use App\Rules\Converter\ValidateTypeMeasurement;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:products,name',
            'measurement_type' => [
                'required',
                'string',
                new ValidateTypeMeasurement(),
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
            'name.required' => 'El nombre del producto es requerido',
            'name.string' => 'El nombre del producto debe ser una cadena de caracteres',
            'name.max' => 'El nombre del producto debe tener máximo 255 caracteres',
            'name.unique' => 'El nombre del producto ya existe',
        ];
    }
}
