<?php

namespace App\Rules\Client;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldPhoneMain implements ValidationRule
{
    public function __construct($oldPhoneMain)
    {
        $this->oldPhoneMain = $oldPhoneMain;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == $this->oldPhoneMain){
            $fail(__('El teléfono principal debe de ser diferente al actual'));
        }
    }
}
