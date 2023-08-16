<?php

namespace App\Rules\Client;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldPhoneSecondary implements ValidationRule
{
    public function __construct($oldPhoneSecondary)
    {
        $this->oldPhoneSecondary = $oldPhoneSecondary;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == $this->oldPhoneSecondary){
            $fail(__('El teléfono secundario debe de ser diferente al actual'));
        }
    }
}
