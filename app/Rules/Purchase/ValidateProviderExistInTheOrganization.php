<?php

namespace App\Rules\Purchase;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateProviderExistInTheOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!auth()->user()->organization->providers()->where('id', $value)->exists()){
            $fail(__('El proveedor no existe en la organización'));
        }
    }
}
