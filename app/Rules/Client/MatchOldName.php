<?php

namespace App\Rules\Client;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldName implements ValidationRule
{
    public function __construct($oldName)
    {
        $this->oldName = $oldName;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == $this->oldName){
            $fail(__('El nombre debe de ser diferente al actual'));
        }
    }
}
