<?php

namespace App\Rules\Client;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class MatchOldMunicipality implements ValidationRule
{
    public function __construct($oldMunicipality)
    {
        $this->oldMunicipality = $oldMunicipality;
    }
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if($value == $this->oldMunicipality){
            $fail(__('El municipio debe de ser diferente al actual'));
        }
    }
}
