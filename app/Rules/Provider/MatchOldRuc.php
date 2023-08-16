<?php

namespace App\Rules\Provider;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldRuc implements ValidationRule
{
    public function __construct($oldRuc)
    {
        $this->oldRuc = $oldRuc;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == $this->oldRuc){
            $fail(__('El RUC debe de ser diferente al actual'));
        }
    }
}
