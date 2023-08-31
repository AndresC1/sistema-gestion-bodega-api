<?php

namespace App\Rules\Sale;

use Closure;
use App\Models\Client;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateClientExistInTheOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $organization_id = auth()->user()->organization->id;
        $client = Client::where('id', $value)
            ->where('organization_id', $organization_id)
            ->get();
        if(count($client) == 0){
            $fail(__("El cliente con el id:".$value." no existe en la organizacion."));
        }
    }
}
