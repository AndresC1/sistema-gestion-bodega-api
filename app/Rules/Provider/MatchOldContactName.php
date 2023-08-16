<?php

namespace App\Rules\Provider;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldContactName implements ValidationRule
{
    public function __construct($oldContactName)
    {
        $this->oldContactName = $oldContactName;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->oldContactName) {
            $fail(__('El nombre del contacto debe de ser diferente al actual'));
        }
    }
}
