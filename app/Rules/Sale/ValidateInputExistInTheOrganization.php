<?php

namespace App\Rules\Sale;

use App\Models\ProductInput;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Exception;

class ValidateInputExistInTheOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $organization_id = auth()->user()->organization->id;
        $productInput = ProductInput::where('id', $value)
            ->where('organization_id', $organization_id)
            ->get();
        if(count($productInput) == 0){
            throw new Exception("La entrada con el id:".$value." no existe en la organizacion.");
        }
    }
}
