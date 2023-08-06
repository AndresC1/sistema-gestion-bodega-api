<?php

namespace App\Rules\User;

use App\Models\User;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Auth;

class VerificationRolePermitted implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if(User::find(Auth::user()->id)->role_id != 1 && $value == 1){
            $fail(_('El usuario no tiene permisos para crear un usuario super administrador'));
        }
    }
}
