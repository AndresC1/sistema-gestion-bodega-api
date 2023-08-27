<?php

namespace App\Rules\ProductInput;

use App\Models\Inventory;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateTypeProduct implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $inventory = Inventory::find($value);

        if ($inventory->type == 'PT') {
            $fail(__("El producto no es un producto terminado."));
        }
    }
}
