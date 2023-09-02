<?php

namespace App\Models\Conversion\ConversionValues;

class WeightConversionValues
{
    public static $conversionValue = [
        'kg' => [
            'kg' => 1,
            'g' => 1000,
            'mg' => 1000000,
            'lb' => 2.20462,
            'oz' => 35.274,
            'ton' => 0.00110231
        ],
        'g' => [
            'kg' => 0.001,
            'g' => 1,
            'mg' => 1000,
            'lb' => 0.00220462,
            'oz' => 0.035274,
            'ton' => 0.00000110231
        ],
        'mg' => [
            'kg' => 0.000001,
            'g' => 0.001,
            'mg' => 1,
            'lb' => 0.00000220462,
            'oz' => 0.000035274,
            'ton' => 0.00000000110231
        ],
        'lb' => [
            'kg' => 0.453592,
            'g' => 453.592,
            'mg' => 453592,
            'lb' => 1,
            'oz' => 16,
            'ton' => 0.000453592
        ],
        'oz' => [
            'kg' => 0.0283495,
            'g' => 28.3495,
            'mg' => 28349.5,
            'lb' => 0.0625,
            'oz' => 1,
            'ton' => 0.0000283495
        ],
        'ton' => [
            'kg' => 907.185,
            'g' => 907185,
            'mg' => 907185000,
            'lb' => 2000,
            'oz' => 32000,
            'ton' => 1
        ]
    ];
}
