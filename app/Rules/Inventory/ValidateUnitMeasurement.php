<?php

namespace App\Rules\Inventory;

use App\Models\Conversion\ConversionValues\LengthConversionValues;
use App\Models\Conversion\ConversionValues\TypeMeasurement;
use App\Models\Conversion\ConversionValues\UnitConversionValues;
use App\Models\Conversion\ConversionValues\VolumeConversionValues;
use App\Models\Conversion\ConversionValues\WeightConversionValues;
use App\Models\Product;
use App\Models\ProductInput;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class ValidateUnitMeasurement implements ValidationRule
{
    protected $product;

    public function __construct($product_id)
    {
        $this->product = Product::find($product_id);
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $type_measurement = [
            'Longitud' => LengthConversionValues::$conversionValue,
            'Masa/Peso' => WeightConversionValues::$conversionValue,
            'Volumen' => VolumeConversionValues::$conversionValue,
            'Unidad' => UnitConversionValues::$conversionValue,
        ];
        $types = array_keys($type_measurement[$this->product->measurement_type]);
        if (!in_array($value, $types)) {
            $fail(__("El campo $attribute debe ser uno de los siguientes: ".implode(', ', $types)));
        }
    }
}
