<?php

namespace App\Rules\OrganizationRule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldCity implements ValidationRule
{
    protected $city;

    public function __construct($city)
    {
        $this->city = $city;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->city) {
            $fail('La '.$attribute.' nueva debe ser diferente a la actual.');
        }
    }
}
