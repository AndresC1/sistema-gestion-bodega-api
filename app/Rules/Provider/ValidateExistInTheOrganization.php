<?php

namespace App\Rules\Provider;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateExistInTheOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(!auth()->user()->organization->providers()->where('name', $value)->doesntExist()) {
            $fail(__('El proveedor ya existe en la organización'));
        }
    }
}
