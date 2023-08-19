<?php

namespace App\Rules\Inventory;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateCodeExistInTheOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(auth()->user()->organization->inventories()->where('code', $value)->exists()){
            $fail(__('El código ya esta siendo usado en el inventario de la organización'));
        }
    }
}
