<?php

namespace App\Rules\Client;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldType implements ValidationRule
{
    public function __construct($oldType)
    {
        $this->oldType = $oldType;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == $this->oldType){
            $fail(__('El tipo de cliente debe de ser diferente al actual'));
        }
    }
}
