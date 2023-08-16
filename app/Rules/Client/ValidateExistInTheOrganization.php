<?php

namespace App\Rules\Client;

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
        if(!auth()->user()->organization->clients()->where('name', $value)->doesntExist()) {
            $fail(__('El cliente ya existe en la organización'));
        }
    }
}
