<?php

namespace App\Rules\Provider;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldAddress implements ValidationRule
{
    public function __construct($oldAddress)
    {
        $this->oldAddress = $oldAddress;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == $this->oldAddress){
            $fail(__('La dirección debe de ser diferente a la actual'));
        }
    }
}
