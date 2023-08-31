<?php

namespace App\Rules\Sale;

use App\Models\Sale;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateNumberBill implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $organization_id = auth()->user()->organization->id;
        $sale = Sale::where('number_bill', $value)
            ->where('organization_id', $organization_id)
            ->get();
        if (count($sale) > 0) {
            $fail(__("El numero de factura ya existe en la organizacion."));
        }
    }
}
