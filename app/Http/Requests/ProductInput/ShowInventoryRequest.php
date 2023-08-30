<?php

namespace App\Http\Requests\ProductInput;

use App\Rules\ProductInput\ValidateTypeProduct;
use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ProductInput\ValidateExistInventoryInOrganization;

class ShowInventoryRequest extends FormRequest
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
            'inventory_id' => [
                'required',
                'exists:inventories,id',
                new ValidateExistInventoryInOrganization(),
                new ValidateTypeProduct()
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
            'inventory_id.required' => 'El campo inventory_id es requerido',
            'inventory_id.exists' => 'El campo inventory_id debe existir en la tabla inventories',
        ];
    }
}
