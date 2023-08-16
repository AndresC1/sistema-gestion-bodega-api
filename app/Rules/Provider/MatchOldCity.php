<?php

namespace App\Rules\Provider;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldCity implements ValidationRule
{
    public function __construct($oldCity)
    {
        $this->oldCity = $oldCity;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->oldCity) {
            $fail(__('La ciudad debe de ser diferente a la actual'));
        }
    }
}
