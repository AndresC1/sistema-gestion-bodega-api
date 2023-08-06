<?php

namespace App\Rules\User;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class MatchOrganization implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(User::find(Auth::user()->id)->organization_id != $value && User::find(Auth::user()->id)->organization_id != null){
            $fail(_('El usuario no pertenece a la organización seleccionada'));
        }
    }
}
