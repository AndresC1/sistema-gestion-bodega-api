<?php

namespace App\Rules\Provider;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldEmail implements ValidationRule
{
    public function __construct($oldEmail)
    {
        $this->oldEmail = $oldEmail;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if ($value == $this->oldEmail) {
            $fail(__('El correo electrónico nuevo debe ser diferente al actual.'));
        }
    }
}
