<?php

namespace App\Rules\OrganizationRule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldAddress implements ValidationRule
{
    protected $address;

    public function __construct($address)
    {
        $this->address = $address;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->address) {
            $fail(__('La '.$attribute.' nueva debe ser diferente a la actual.'));
        }
    }
}
