<?php

namespace App\Rules\OrganizationRule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldMunicipality implements ValidationRule
{
    protected $municipality;

    public function __construct($municipality)
    {
        $this->municipality = $municipality;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->municipality) {
            $fail('El '.$attribute.' nueva debe ser diferente a la actual.');
        }
    }
}
