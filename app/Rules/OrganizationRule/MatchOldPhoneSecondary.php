<?php

namespace App\Rules\OrganizationRule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldPhoneSecondary implements ValidationRule
{
    protected $phoneSecondary;

    public function __construct($phoneSecondary)
    {
        $this->phoneSecondary = $phoneSecondary;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->phoneSecondary) {
            $fail('El '.$attribute.' nuevo debe ser diferente al actual.');
        }
    }
}
