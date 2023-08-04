<?php

namespace App\Rules\OrganizationRule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldPhoneMain implements ValidationRule
{
    protected $phone_main;

    public function __construct($phone_main)
    {
        $this->phone_main = $phone_main;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->phone_main) {
            $fail(__('El '.$attribute.' nuevo debe ser diferente al actual.'));
        }
    }
}
