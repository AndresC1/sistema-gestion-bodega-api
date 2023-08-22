<?php

namespace App\Rules\ProductInput;

use App\Models\DetailsPurchase;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateDetailsPurchaseExistInTheOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $organization_id = auth()->user()->organization->id;
        $detailsPurchase = DetailsPurchase::find($value)->purchase->organization_id;

        if ($detailsPurchase != $organization_id) {
            $fail(__("El detalle de la compra con el id:".$value." no existe en la organizacion."));
        }
    }
}
