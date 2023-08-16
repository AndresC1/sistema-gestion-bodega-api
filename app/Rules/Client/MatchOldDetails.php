<?php

namespace App\Rules\Client;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldDetails implements ValidationRule
{
    public function __construct($oldDetails)
    {
        $this->oldDetails = $oldDetails;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == $this->oldDetails){
            $fail(__('El detalle debe de ser diferente al actual'));
        }
    }
}
