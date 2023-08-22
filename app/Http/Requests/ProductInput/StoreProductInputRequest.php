<?php

namespace App\Http\Requests\ProductInput;

use App\Rules\ProductInput\ValidateExistInventoryInOrganization;
use App\Rules\ProductInput\ValidateTypeProduct;
use Illuminate\Foundation\Http\FormRequest;

class StoreProductInputRequest extends FormRequest
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
            'quantity' => 'required|integer|min:1'
        ];
    }
}
