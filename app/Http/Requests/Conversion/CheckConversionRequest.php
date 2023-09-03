<?php

namespace App\Http\Requests\Conversion;

use App\Rules\Converter\ValidateUnitExist;
use Illuminate\Foundation\Http\FormRequest;

class CheckConversionRequest extends FormRequest
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
            'amount' => 'required|numeric',
            'from' => [
                'required',
                'string',
                'max:3',
                'min:1',
                new ValidateUnitExist()
            ],
            'to' => [
                'required',
                'string',
                'max:3',
                'min:1',
                new ValidateUnitExist()
            ],
        ];
    }
}
