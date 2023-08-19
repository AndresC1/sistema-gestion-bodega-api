<?php

namespace App\Rules\Inventory;

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
        if(auth()->user()->organization->inventories()->where('product_id', $value)->exists()){
            $fail(__('El producto ya existe en el inventario de la organización'));
        }
    }
}
