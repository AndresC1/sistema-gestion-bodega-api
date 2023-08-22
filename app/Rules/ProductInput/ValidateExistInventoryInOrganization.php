<?php

namespace App\Rules\ProductInput;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateExistInventoryInOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $inventory = auth()->user()->organization->inventories()->find($value);

        if (!$inventory) {
            $fail(__("El inventario no existe en la organizacion."));
        }
    }
}
