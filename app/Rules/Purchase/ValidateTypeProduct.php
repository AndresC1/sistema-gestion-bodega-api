<?php

namespace App\Rules\Purchase;

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
        $data_inventory = auth()->user()->organization->inventories
            ->where('product_id', $value)
            ->where('type', 'MP')
            ->first();
        if($data_inventory == null){
            $fail(__('El producto no se encuentra en el inventario de materia prima'));
        }
    }
}
