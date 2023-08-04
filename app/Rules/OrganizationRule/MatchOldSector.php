<?php

namespace App\Rules\OrganizationRule;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldSector implements ValidationRule
{
    protected $sector;

    public function __construct($sector)
    {
        $this->sector = $sector;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail, ): void
    {
        if ($value == $this->sector) {
            $fail('El '.$attribute.' nuevo debe ser diferente al actual.');
        }
    }
}
