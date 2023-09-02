<?php

namespace App\Rules\Converter;

use App\Models\Conversion\ConversionValues\TypeMeasurement;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateTypeMeasurement implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        if (!in_array($value, TypeMeasurement::$typeMeasurement)) {
            $fail(__('El tipo de medida no es válido'));
        }
    }
}
